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

Route::middleware('view')->post('/login' ,[
    'uses' => 'UserController@login'
]);

Route::middleware('view')->post('/newUser' ,[
    'uses' => 'UserController@newUser'
]);

Route::middleware('view')->post('/updateAdmin' ,[
    'uses' => 'UserController@updateAdmin'
]);

Route::middleware('view')->post('/updateSeller' ,[
    'uses' => 'UserController@updateSeller'
]);

Route::middleware('view')->get('/getAdmin' ,[
    'uses' => 'UserController@getAdmin'
]);

Route::middleware('view')->get('/getSeller' ,[
    'uses' => 'UserController@getSeller'
]);


//Items

Route::middleware('view')->post('/addItem' ,[
    'uses' => 'ItemController@newItem'
]);

Route::middleware('view')->get('/getItems' ,[
    'uses' => 'ItemController@getItems',

]);

Route::middleware('view')->get('/getAvailableItems/' ,[
    'uses' => 'ItemController@getAvailableItems'
]);

Route::middleware('view')->get('/getAvailableItemByID/{id}' ,[
    'uses' => 'ItemController@getAvailableItemByID'
]);

Route::middleware('view')->get('/getItem/{id}' ,[
    'uses' => 'ItemController@getItemByID'
]);

Route::middleware('view')->get('/searchItem/{word}' ,[
    'uses' => 'ItemController@searchItem'
]);

Route::middleware('view')->get('/searchByBarcode/{barcode}',[
    'uses' => 'ItemController@searchBarcode'
]);

Route::middleware('view')->get('/updateQty/{id}/{value}',[
    'uses' => 'ItemController@updateQty'
]);

Route::middleware('view')->get('/updateStatus/{id}',[
    'uses' => 'ItemController@updateStatus'
]);

Route::middleware('view')->get('/checkItemCode/{itemCode}',[
    'uses' => 'ItemController@checkItemCode'
]);

Route::middleware('view')->get('/barcode/{itemCode}/{barcode}',[
    'uses' => 'ItemController@saveBarcode'
]);

Route::middleware('view')->delete('/deleteItem/{id}',[
    'uses' => 'ItemController@deleteItem'
]);

Route::middleware('view')->post('/updateItem/{id}',[
    'uses' => 'ItemController@updateItem'
]);

Route::middleware('view')->get('/warranty/{id}',[
    'uses' => 'ItemController@getWarranty'
]);

Route::middleware('view')->get('/reduceStock/{id}/{value}',[
    'uses' => 'ItemController@reduceStock'
]);

//Categories
Route::middleware('view')->post('/addCategory',[
    'uses' => 'CategoryController@newCategory'
]);

Route::middleware('view')->get('/categories/',[
    'uses' => 'CategoryController@getCategories'
]);

Route::middleware('view')->get('/categories/{id}',[
    'uses' => 'CategoryController@getCategoryById'
]);

Route::middleware('view')->get('/deleteCategory/{id}',[
    'uses' => 'CategoryController@deleteCategory'
]);

Route::middleware('view')->post('/updateCategory/{id}',[
    'uses' => 'CategoryController@updateCategory'
]);


//Sales
Route::middleware('view')->get('/saleDetails',[
    'uses' => 'SalesController@getData'
]);

Route::middleware('view')->get('/incomeByDate',[
    'uses' => 'SalesController@incomeByDate'
]);

Route::middleware('view')->get('/incomeByMonth',[
    'uses' => 'SalesController@incomeByMonth'
]);

Route::middleware('view')->get('/incomeLastMonth',[
    'uses' => 'SalesController@incomeLastMonth'
]);

Route::middleware('view')->post('/newSale/{seller}/{invoiceID}',[
    'uses' => 'SalesController@insertSale'
]);

Route::middleware('view')->post('/newsaleInvoice/{invoiceID}',[
    'uses' => 'SalesController@newsaleInvoice'
]);


//Dealers
Route::middleware('view')->get('/dealers',[
    'uses' => 'DealerController@getDealers'
]);

Route::middleware('view')->get('/dealers/{id}',[
    'uses' => 'DealerController@getDealerByID'
]);

Route::middleware('view')->post('/addDealer',[
    'uses' => 'DealerController@addNew'
]);

Route::middleware('view')->post('/updateDealer/{id}',[
    'uses' => 'DealerController@updateDealer'
]);


Route::middleware('view')->delete('/deleteDealer/{id}',[
    'uses' => 'DealerController@deleteDealer'
]);

//Details
Route::middleware('view')->get('/details',[
    'uses' => 'DetailsController@getDetails'
]);

Route::middleware('view')->post('/updateDetails',[
    'uses' => 'DetailsController@updateDetails'
]);

//Lend

Route::middleware('view')->get('/lends',[
    'uses' => 'LendController@getLend'
]);

Route::middleware('view')->get('/addMoney/{id}/{amount}',[
    'uses' => 'LendController@addMoney'
]);

Route::middleware('view')->delete('/deleteLend/{id}',[
    'uses' => 'LendController@deleteLend'
]);

Route::middleware('view')->post('/newLendInvoice/{invoiceID}',[
    'uses' => 'LendController@newLendInvoice'
]);

Route::middleware('view')->post('/newLend',[
    'uses' => 'LendController@newLend'
]);
