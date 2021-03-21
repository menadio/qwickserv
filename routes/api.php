<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group( function () {

    // Unauthenticated routes
    Route::group(['namespace' => 'App\Http\Controllers\v1'], function ($router) {

        Route::post('register', 'RegisterController@individual'); // register new user account
        
        Route::post('register/business', 'RegisterController@business'); // register new business account
    
        Route::post('login', 'LoginController@login'); // authenticate user

    });


    // Authentucated routes
    Route::group(['namespace' => 'App\Http\Controllers\v1', 'middleware' => ['auth:sanctum']], function ($router) {

        Route::post('logout', 'LogoutController@logout'); // revoke authenticated user access token
    
        Route::post('verify', 'VerificationController@verify'); // verify authenticated user email
    
        Route::get('verify/code', 'VerificationController@resend'); // resend verification code
    
        Route::post('consent/accept', 'ConsentController@accept'); // accept terms of use
    
        Route::post('consent/reject', 'ConsentController@reject'); // reject terms of use
    
        Route::get('categories', 'CategoryController@index'); // get all categories

        Route::get('categories/{category}', 'CategoryController@show'); // get category resource
    
        Route::get('business/profile', 'BusinessController@profile'); // get a business profile

        Route::get('business/{business}', 'BusinessController@show')->middleware(['consented']); // get a business details

        Route::post('business/{business}/reserve', 'BusinessController@reserve'); // make business reservation

        Route::put('business/{business}/upload-cover', 'BusinessController@uploadCover'); // upload a business cover image

        Route::put('business/{business}', 'BusinessController@update'); // update a business resource

        Route::post('business/{business}/photos', 'BusinessPhotoController@upload'); // upload business photos

        // Route::put('business/{business}/hours', 'BusinessHourController@update'); // update business hours

        Route::get('services', 'ServiceController@index'); // get all active services

        // user endpoints
        Route::get('bookings/reserved', 'BookingController@reserved'); // get user reserved bookings collection

        Route::get('bookings/active', 'BookingController@active'); // get active bookings collection

        Route::get('bookings/completed', 'BookingController@completed'); // get completed bookings collection

    });

});