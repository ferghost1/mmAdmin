<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'UserController@login')->middleware('authAgency');

// Users
Route::post('/user', 'UserController@createUser')->middleware('authUser');
Route::put('/user/{id}', 'UserController@updateUser')->middleware('authUser');

// Members
Route::get('/members', 'UserController@getMembers')->middleware('authUser');
Route::post('/member', 'UserController@createUser')->middleware('authUser');
Route::post('/member/login', 'UserController@loginMember')->middleware('authAgency', 'authUser');
Route::put('/member/{id}', 'UserController@updateMember')->middleware('authUser');
Route::put('/member/{id}/deposite', 'UserController@deposite')->middleware('authUser');
Route::put('/member/{id}/withdrawal', 'UserController@withdrawal')->middleware('authUser');
Route::post('/member_buy', 'UserController@withdrawal')->middleware('authUser');

// Products
Route::get('/products', 'ProductController@getProducts')->middleware('authUser');
Route::put('/products', 'ProductController@getProducts')->middleware('authUser');

// Storage
Route::put('/agency_storage/add', 'AgencyStorage@addProduct')->middleware('authUser');
Route::put('/agency_storage/remove', 'AgencyStorage@removeProduct')->middleware('authUser');

// Reports
Route::get('agency/transaction', 'AgencyTransactionController@getTransactions')->middleware('authUser');
Route::get('user/transaction', 'AgencyTransactionController@getTransactions')->middleware('authUser');