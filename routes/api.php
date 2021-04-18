<?php

use App\Http\Controllers\v1\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('payments/webhook', [PaymentController::class, 'webhook']); // handle payment response

Route::prefix('v1')->group( function () {

    // Unauthenticated routes

    Route::group(['namespace' => 'App\Http\Controllers\v1'], function ($router) {

        Route::post('register', 'RegisterController@individual'); // register new user account
        
        Route::post('register/business', 'RegisterController@business'); // register new business account
    
        Route::post('login', 'LoginController@login'); // authenticate user

        Route::get('categories', 'CategoryController@index'); // get all categories

        Route::get('categories/{category}', 'CategoryController@show'); // get category resource

        Route::get('businesses/category/{category}', 'BusinessController@filtered'); // filter businesses by category

        Route::post('forgot-password', 'PasswordController@sendResetLink')->name('password.email'); // request password reset link

        Route::post('reset-password', 'PasswordController@resetPassword')->name('password.reset'); // reset user password

        Route::get('banks', 'BankController@index'); // get collection of banks
    });


    // Authentucated routes

    Route::group(['namespace' => 'App\Http\Controllers\v1', 'middleware' => ['auth:sanctum']], function ($router) {

        Route::post('logout', 'LogoutController@logout'); // revoke authenticated user access token
    
        Route::post('verify', 'VerificationController@verify'); // verify authenticated user email
    
        Route::get('verify/code', 'VerificationController@resend'); // resend verification code
    
        Route::post('consent/accept', 'ConsentController@accept'); // accept terms of use
    
        Route::post('consent/reject', 'ConsentController@reject'); // reject terms of use
    
        
        // business endpoints
    
        Route::get('business/profile', 'BusinessController@profile'); // get a business profile

        Route::get('business/{business}', 'BusinessController@show')->middleware(['consented']); // get a business details

        Route::post('business/{business}/reserve', 'BusinessController@reserve'); // make business reservation

        Route::put('business/{business}/logo', 'BusinessController@uploadLogo'); // upload a business logo

        Route::put('business/{business}/upload-cover', 'BusinessController@uploadCover'); // upload a business cover image

        Route::put('business/{business}', 'BusinessController@update'); // update a business resource

        Route::post('business/{business}/photos', 'BusinessPhotoController@upload'); // upload business photos

        Route::delete('business/{business}/photos/{photo}', 'BusinessPhotoController@delete'); // remove a business photo

        Route::put('business-hours/{businesshour}', 'BusinessHourController@update'); // update business hours

        Route::get('services', 'ServiceController@index'); // get all active services

        Route::get('business/{business}/bookings', 'BusinessController@bookings'); // get all open business bookings

        Route::get('business/{business}/bookings/completed', 'BusinessController@completed'); // get all business completed bookings

        Route::get('business/{business}/reviews', 'BusinessController@reviews'); // get business reviews

        Route::get('bank-details', 'BusinessBankController@index'); // get business bank details

        Route::post('bank-details', 'BusinessBankController@store'); // store business bank details

        
        // user endpoints

        Route::get('profile', 'UserController@profile'); // get user profile

        Route::put('profile-update', 'UserController@update'); // update user resource

        Route::post('profile/image-update', 'UserController@updateProfileImage'); // update user profile image

        Route::get('bookings/reserved', 'BookingController@reserved'); // get user reserved bookings collection

        Route::get('bookings/active', 'BookingController@active'); // get active bookings collection

        Route::get('bookings/completed', 'BookingController@completed'); // get completed bookings collection

        Route::get('bookings/{booking}', 'BookingController@show'); // get a booking reservation details

        Route::post('bookings/{booking}/cancel', 'BookingController@cancel'); // cancel a booking reservation

        Route::post('bookings/{booking}/release-pay', 'BookingController@releasePay'); // release bookings reservation fee to artisan

        Route::post('bookings/{booking}/review', 'ReviewController@store'); // review a business service

        Route::get('bookings/{booking}/payment', 'PaymentController@makePayment'); // make booking payment

        
        // miscellaneous

        
        Route::get('business-near-by', 'UserController@nearBy'); // get business near by user
        
        Route::post('feedback', 'FeedbackController@store'); // allows user leave a feedback
        
        
        // searching

        Route::post('search', 'SearchController@search'); // run a search

        // test
        Route::post('categories', 'CategoryController@store'); // add new business category

        Route::put('categories/{category}', 'CategoryController@update'); // update a business category

    });

});