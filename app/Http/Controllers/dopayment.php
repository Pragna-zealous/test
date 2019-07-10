<?php
$input = $request->all();
        // echo env('RAZORPAY_KEY');
        $order_id = $input['order_id'];
        if ($input['type'] == 'razorpay') {

            //get API Configuration 
            $api = new Api('rzp_test_lZAJDviG4Iirxp', 'DKYxyzOceZwqpePHwWVTEaTS');

            //Fetch payment information by payment_id
            $payment = $api->payment->fetch($input['payment_id']);
        }

        if(count($input)  && !empty($input['payment_id'])) {
            if ($input['type'] == 'stripe') {
                $stripe = Stripe::make('sk_test_KOKv6djbziQhpPN7fbmbr6HY00CIwPx7rr');
                try {
                    $charge = $stripe->charges()->create([
                        'card' => $input['payment_id'],
                        'currency' => 'USD',
                        'amount' => $input['amount'],
                        'expand' => array('balance_transaction'),
                        'metadata' => ["order_id" => $order_id],
                        'description' => 'Add in wallet',
                    ]);
                    $paymentsuccess = false;
                    if($charge['status'] == 'succeeded') {
                        // PaymentTransactions::create($data);
                        $paymenttransaction = PaymentTransactions::where('order_id',$order_id)->first();
                        $paymenttransaction->amount = substr($charge['amount'], 0, -2);
                        $paymenttransaction->fee = sprintf('%.2f', $charge['balance_transaction']['fee'] / 100);
                        $paymenttransaction->currency = $charge['currency'];
                        $paymenttransaction->method = $charge['payment_method_details']['type'];
                        $paymenttransaction->status = $charge['status'];
                        $paymenttransaction->description = $charge['description'];
                        $paymenttransaction->payment_id = $charge['id'];

                        $paymenttransaction->save();

                        $arr = array('msg' => 'Payment successfully credited', 'status' => true);

                        $paymentsuccess = true;
                    } else {
                        $arr = array('msg' => 'Money not add in wallet!!', 'status' => true);
                    }

                    //Send Email notification after successfull payment
                    if( $paymentsuccess == true ){
                        $this->SendEmailNotification($charge['currency'], $charge['id']);
                    }

                    return Response()->json($arr);

                } catch (Exception $e) {
                    $arr = array('msg' => $e->getMessage(), 'status' => false);
                }
            }else{
                try {
                    $response = $api->payment->fetch($input['payment_id'])->capture(array('amount'=>$payment['amount']));

                    $paymenttransaction = PaymentTransactions::where('order_id',$order_id)->first();
                    $paymenttransaction->amount = substr($response['amount'], 0, -2);
                    $paymenttransaction->fee = substr($response['fee'], 0, -2);
                    $paymenttransaction->tax = substr($response['tax'], 0, -2);
                    $paymenttransaction->currency = $response['currency'];
                    $paymenttransaction->method = $response['method'];
                    $paymenttransaction->status = $response['status'];
                    $paymenttransaction->description = $response['description'];
                    $paymenttransaction->payment_id = $input['payment_id'];

                    $paymenttransaction->save();

                    $arr = array('msg' => 'Payment successfully credited', 'status' => true);

                    //Send Email notification after successfull payment
                    $this->SendEmailNotification($response['currency'], $input['payment_id']);

                    return Response()->json($arr); 

                } catch (\Exception $e) {
                    $arr = array('msg' => $e->getMessage(), 'status' => false);
                    return Response()->json($arr);    
                }
            }
            // Do something here for store payment details in database...
        }