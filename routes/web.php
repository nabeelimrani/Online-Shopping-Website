<?php
use Illuminate\Support\Facades\Route;
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
Auth::routes([
	// 'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
	]);
Route::get('/restt',function()
{
	session()->flush();
});
Route::get('/', [App\Http\Controllers\MainController::class, 'index'])->name('main');

Route::post('/removecompare', [App\Http\Controllers\MainController::class, 'removecompare'])->name('removecompare');
Route::post('/getdetail', [App\Http\Controllers\MainController::class, 'getdetail'])->name('getdetail');
	
Route::post('/additem', [App\Http\Controllers\MainController::class, 'additem'])->name('additem');
Route::post('/orderbill', [App\Http\Controllers\MainController::class, 'orderbill'])->name('orderbill');
Route::post('/checkinfo', [App\Http\Controllers\MainController::class, 'checkinfo'])->name('checkinfo');
Route::post('/placeorder', [App\Http\Controllers\MainController::class, 'placeorder'])->name('placeorder');
Route::post('/cityinfo', [App\Http\Controllers\MainController::class, 'cityinfo'])->name('cityinfo');
Route::post('/addcoupan', [App\Http\Controllers\MainController::class, 'addcoupan'])->name('addcoupan');
Route::post('/loadcart', [App\Http\Controllers\MainController::class, 'loadcart'])->name('loadcart');
Route::post('/loadcartpage', [App\Http\Controllers\MainController::class, 'loadcartpage'])->name('loadcartpage');
Route::post('/removeproduct', [App\Http\Controllers\MainController::class, 'removeproduct'])->name('removeproduct');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/cart', [App\Http\Controllers\MainController::class, 'cart'])->name('cart');
Route::get('/checkout', [App\Http\Controllers\MainController::class, 'checkout'])->name('checkout');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::post('/updateaddress', [App\Http\Controllers\HomeController::class, 'updateaddress'])->name('updateaddress');
Route::post('/updateaccount', [App\Http\Controllers\HomeController::class, 'updateaccount'])->name('updateaccount');
Route::get('/admin',[App\http\Controllers\AdminController::class,'index'])->name('admin')->middleware("can:create,App\models\User");
Route::get('/admin/userpage',[App\http\Controllers\AdminController::class,'userpage'])->name('userpage')->middleware("can:create,App\models\User");
Route::post('/admin/adduser',[App\http\Controllers\AdminController::class,'adduser'])->name('adduser')->middleware("can:create,App\models\User");
Route::post('/admin/operatortable',[App\http\Controllers\AdminController::class,'operatortable'])->name('operatortable')->middleware("can:create,App\models\User");
Route::post('/admin/updateoperatormodal',[App\http\Controllers\AdminController::class,'updateoperatormodal'])->name('updateoperatormodal')->middleware("can:create,App\models\User");
Route::post('/admin/updateoperatordata',[App\http\Controllers\AdminController::class,'updateoperatordata'])->name('updateoperatordata')->middleware("can:create,App\models\User");
Route::post('/admin/deleteoperator',[App\http\Controllers\AdminController::class,'deleteoperator'])->name('deleteoperator')->middleware("can:create,App\models\User");
Route::post('/admin/deleteoperator',[App\http\Controllers\AdminController::class,'deleteoperator'])->name('deleteoperator')->middleware("can:create,App\models\User");
Route::post('/admin/enterproduct',[App\http\Controllers\AdminController::class,'enterproduct'])->name('enterproduct')->middleware("can:create,App\models\User");
Route::get('/admin/addproducts',[App\http\Controllers\AdminController::class,'addproducts'])->name('addproducts')->middleware("can:create,App\models\User");


Route::get("/viewoperatorpage",[App\http\Controllers\AdminController::Class,'viewoperatorpage'])->name("operatorpage");
Route::post('/updateorderstatus',[App\http\Controllers\AdminController::class,'updateorderstatus'])->name('updateorderstatus');
Route::post('/changestatus',[App\http\Controllers\AdminController::class,'changestatus'])->name('changestatus');
Route::post('/delproduct',[App\http\Controllers\AdminController::class,'delproduct'])->name('delproduct');
Route::post('/editproduct',[App\http\Controllers\AdminController::class,'editproduct'])->name('editproduct');
Route::get('/stock',[App\http\Controllers\StockController::class,'stock'])->name('stock');
Route::get('/addstock',[App\http\Controllers\StockController::class,'addstock'])->name('addstock');
Route::post('/enterstock',[App\http\Controllers\StockController::class,'enterstock'])->name('enterstock');
Route::post('/storestock',[App\http\Controllers\StockController::class,'storestock'])->name('storestock');
Route::post('/delstock',[App\http\Controllers\StockController::class,'delstock'])->name('delstock');

Route::post('/removestock',[App\http\Controllers\StockController::class,'removestock'])->name('removestock');
Route::get('/editstock/{id}', [App\Http\Controllers\StockController::class, 'editstock'])->name('editstock');
Route::get('/payment', [App\Http\Controllers\PaymentController::class, 'payment'])->name('payment');
Route::post('/getbalance', [App\Http\Controllers\PaymentController::class, 'getbalance'])->name('getbalance');
Route::post('/addpayment', [App\Http\Controllers\PaymentController::class, 'addpayment'])->name('addpayment');
Route::post('/addreciept', [App\Http\Controllers\PaymentController::class, 'addreciept'])->name('addreciept');
Route::post('/delpayment', [App\Http\Controllers\PaymentController::class, 'delpayment'])->name('delpayment');
Route::get('/reciept', [App\Http\Controllers\PaymentController::class, 'reciept'])->name('reciept');
Route::get('/stockledger', [App\Http\Controllers\PaymentController::class, 'stockledger'])->name('stockledger');
Route::get('/vendorledger', [App\Http\Controllers\PaymentController::class, 'vendorledger'])->name('vendorledger');
Route::get('/saleledger', [App\Http\Controllers\PaymentController::class, 'saleledger'])->name('saleledger');
Route::get('/customerledger', [App\Http\Controllers\PaymentController::class, 'customerledger'])->name('customerledger');
Route::get('/salestatus', [App\Http\Controllers\StockController::class, 'salestatus'])->name('salestatus');



Route::post('/searchcustomerledger', [App\Http\Controllers\PaymentController::class, 'searchcustomerledger'])->name('searchcustomerledger');
Route::post('/searchvendorledger', [App\Http\Controllers\PaymentController::class, 'searchvendorledger'])->name('searchvendorledger');
Route::post('/searchsaleledger', [App\Http\Controllers\PaymentController::class, 'searchsaleledger'])->name('searchsaleledger');

Route::post('/search', [App\Http\Controllers\MainController::class, 'search'])->name('search');


Route::post('/ratings', [App\Http\Controllers\MainController::class, 'store'])->name('ratings.store');
Route::get('/compare', [App\Http\Controllers\MainController::class, 'compare'])->name('compare');
Route::get('/singleproduct/{id}', [App\Http\Controllers\MainController::class, 'singleproduct'])->name('singleproduct');





Route::get('/{slug}', [App\Http\Controllers\MainController::class, 'showcategory'])->name('showcategory');