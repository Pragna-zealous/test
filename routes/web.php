<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
//Register user through AJAX from donation page

Route::post('ajax_register', 'HomeController@create_user_ajax')->name('ajax_register');
Route::post('footer_signup', 'HomeController@footer_signup')->name('footer_signup');

Route::get('/', 'HomeController@index');
Route::get('login/{provider}','Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

//Donate Page
Route::get('donation', 'DonationController@index')->name('donation');
Route::get('custompage_load/{page_slug}', 'HomeController@custompage_load');
Route::get('about_us', 'HomeController@about_us');

//Payment
// Route::post('dopayment', 'DonationController@dopayment')->name('dopayment');
Route::get('payment_success', 'DonationController@payment_success')->name('payment_success');
Route::post('payment', 'DonationController@payment')->name('payment');
Route::get('verify_email', 'DonationController@verify_email')->name('verify_email');
Route::get('change_currency', 'DonationController@change_currency')->name('change_currency');

/*--- Logged In Users Routes ----*/
Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
	Route::get('/profile', 'HomeController@profile')->name('profile');
	Route::get('destroy_profile_image/{id}', 'HomeController@destroy_profile_image');
	Route::post('/edit_profile', 'HomeController@edit_profile')->name('edit_profile');
	Route::get('/transaction', 'HomeController@transaction')->name('transaction');

	// Razorpay payment 
	// Route::get('pay', 'RazorpayController@pay')->name('pay');
	//Stripe payment
	// Route::post('addmoney/stripe', array('as' => 'addmoney.stripe','uses' => 'DonationController@postPaymentWithStripe'));
});

/*--- Admin Users Routes ----*/
Route::group(['middleware' => 'auth.admin'], function () {
	Route::Resource('users','UserController');
	Route::get('destroy_banner_image/{id}', 'CustompageController@destroy_banner_image');
	// Partner Images Backend
	Route::get('partner_images', 'CustompageController@partner_images');
	Route::post('store_partner_images', 'CustompageController@store_partner_images');
	Route::get('ajaxRequestPartner', 'CustompageController@ajaxRequestPartner');
	Route::post('ajaxRequestPartner', 'CustompageController@ajaxRequestPartnerPost');

	Route::Resource('custompage', 'CustompageController');
	Route::get('destroy_user_image/{id}', 'TestimonialController@destroy_user_image');
	Route::Resource('testimonial', 'TestimonialController');
	Route::get('users/delete/{id}','UserController@delete');
	Route::get('comments','CommentsController@index');
	Route::get('chart_settings','HomeController@chart_settings')->name('chart_settings');
	Route::post('chart_settings.store','HomeController@save_chart_settings');
	Route::get('ajaxRequest', 'HomeController@ajaxRequest');
	Route::post('ajaxRequest', 'HomeController@ajaxRequestPost');
	Route::get('donation_backend', 'DonationController@donation_backend')->name('donation_backend');
	Route::post('donation_save', 'DonationController@donation_save')->name('donation_save');
	Route::get('mass_communication', 'MasscommunicationController@mass_communication')->name('mass_communication');
	Route::post('autocomplete', 'MasscommunicationController@autocomplete')->name('autocomplete');
	Route::post('masscommunication_send', 'MasscommunicationController@masscommunication_send')->name('masscommunication_send');
	Route::get('headersetting', 'MenuSettingsController@headersetting')->name('headersetting');
	Route::get('footersetting', 'MenuSettingsController@footersetting')->name('footersetting');
	Route::Resource('menuheadersetting', 'MenuSettingsController');
	Route::Resource('socialmedia','SocialMediaController');

	// Programme Images Backend
	Route::get('programme_images', 'CustompageController@programme_images');
	Route::post('store_programme_images', 'CustompageController@store_programme_images');
	Route::get('ajaxRequestProgramme', 'CustompageController@ajaxRequestProgramme');
	Route::post('ajaxRequestProgramme', 'CustompageController@ajaxRequestProgrammePost');
});

/*--- Member Users Routes ----*/
Route::group(['middleware' => 'auth.member'], function () {
	
});