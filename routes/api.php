<?php

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/searchCustomers', function (Request $request) {
    return Customer::searchCustomers($request->search)->select(
        'id', 'name',  'nickname', 'tel'
         )
    ->paginate(50);
});


/*Route::middleware('auth:sanctum')->get('/searchCustomers', function (Request $request) {
    $c = DB::table('customers')->select('id')->where('name', 'like', '%'.$request->search.'%')->get();
    $p = DB::table('purchases')->where('customer_id', 'in', $c)->get();
 
    return $p;
});*/
 

/*Route::middleware('auth:sanctum')->get('/searchPurchases', function (Request $request) {
    return Purchase::searchPurchasesByCustomer($request->search)->select('id', 'name', 'nickname', 'tel')->paginate(50);
});*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    dd("User...cekk");
    return $request->user();
});
