@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Transaction History</li>
</ol>

<div class="row justify-content-center">
    <div class="col-md-12">
        @include('errors.alerts')

        <div class="card">
            <div class="card-header">Transaction History Listing </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Payment Gateway</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Fees</th>
                                <th>Status</th>
                                <th>Order ID</th>
                                <th>Payment ID</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($subscriptionsdata as $transaction)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{(($transaction->user && $transaction->user->name) ? $transaction->user->name : '')}}</td>
                                    <td>{{$transaction->type}}</td>
                                    <td>{{$transaction->method}}</td>
                                    <td>{{($transaction->currency == 'INR' ? '₹' : '$').($transaction->amount ? $transaction->amount : 0)}}</td>
                                    <td>{{($transaction->currency == 'INR' ? '₹' : '$').($transaction->fee ? $transaction->fee : 0)}}</td>
                                    <td>{{$transaction->status}}</td>
                                    <td>{{$transaction->order_id}}</td>
                                    <td>{{$transaction->payment_id}}</td>
                                    <td>{{$transaction->email}}</td>
                                    <td>{{$transaction->contact}}</td>
                                    <td>{{$transaction->description}}</td>
                                    <td>{{date('d-m-Y',strtotime($transaction->created_at))}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection