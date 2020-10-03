<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function() {
    Route::get('accounts/{id}', 'AccountController@show');

    Route::get('accounts/{id}/transactions', 'TransactionController@index');

    Route::post('accounts/{id}/transactions', 'TransactionController@store');

    //TODO add currency support if you have enough time
    Route::get('currencies', function () {
        $account = DB::table('currencies')
            ->get();

        return $account;
    });
});
