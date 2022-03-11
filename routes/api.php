<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\CompanyController;

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

// Contact
Route::get('/contact/all', 'App\Http\Controllers\ContactController@showAll')->name('contacts.showall');
Route::post('/contact/update/{contact}', 'App\Http\Controllers\ContactController@update')->name('contact.update');

// Address
Route::get('/address/ziplookup/{zip}', 'App\Http\Controllers\AddressController@zipLookup')->name('addresses.zipLookup');
Route::post('/address/update/all', 'App\Http\Controllers\AddressController@updateAll')->name('addresses.show');

// Email
Route::post('email/update/all', 'App\Http\Controllers\EmailController@updateAll')->name('emails.updateAll');

// Phone
Route::post('/phone/update/all', 'App\Http\Controllers\PhoneController@updateAll')->name('phones.updateAll');

// Position
Route::post('/position/update/contact', 'App\Http\Controllers\PositionController@updateContact')->name('position.updateContact');
Route::post('/position/update/all', 'App\Http\Controllers\PositionController@updateAll')->name('position.updateAll');

// Department
Route::get('/department/{company_id}', 'App\Http\Controllers\DepartmentController@showAll')->name('departments.show');
Route::get('/department/positions/{department}', 'App\Http\Controllers\DepartmentController@showAllPositions')->name('position.showAllPositions');
Route::post('/department/update/all', 'App\Http\Controllers\DepartmentController@updateAll')->name('departments.updateAll');

// Company
Route::get('/company/all', 'App\Http\Controllers\CompanyController@showAll')->name('companies.showAll');
Route::post('/company/update/{company}', 'App\Http\Controllers\CompanyController@update')->name('companies.update');
Route::post('/company/destroy/{company}', 'App\Http\Controllers\CompanyController@destroy')->name('comapnies.destroy');

Route::resources([
    'contact' => ContactController::class,
    'address' => AddressController::class,
    'department' => DepartmentController::class,
    'email' => EmailController::class,
    'phone' => PhoneController::class,
    'company' => CompanyController::class
]);



