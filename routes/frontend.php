<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend as FRONTEND;



Auth::routes();

Route::get('/',  			        [FRONTEND\HomeController::class,'index']);
Route::get('/about', 	 	        [FRONTEND\HomeController::class,'about']);
Route::get('/blogs',  		        [FRONTEND\BlogController::class,'index']);
Route::get('/blog/{slug}',          [FRONTEND\BlogController::class,'show']);
Route::get('/category/{slug}/{id}', [FRONTEND\BlogController::class,'category']);
Route::get('/tag/{slug}/{id}',      [FRONTEND\BlogController::class,'tag']);
Route::get('/team',  		 		[FRONTEND\HomeController::class,'team']);
Route::get('/how-its-work',  		[FRONTEND\HomeController::class,'work']);
Route::get('/faq',           		[FRONTEND\HomeController::class,'faq']);
Route::get('/pricing',       		[FRONTEND\PricingController::class,'index']);
Route::get('/register/{id}', 		[FRONTEND\PricingController::class,'register'])->middleware('guest');
Route::post('/register-plan/{id}',  [FRONTEND\PricingController::class,'registerPlan'])->middleware('guest');
Route::get('/contact',       		[FRONTEND\ContactController::class,'index']);
Route::post('/send-mail',      		[FRONTEND\ContactController::class,'sendMail'])->name('send.mail');
Route::get('/features',      		[FRONTEND\FeaturesController::class,'index']);
Route::get('/feature/{slug}',		[FRONTEND\FeaturesController::class,'show']);
Route::get('/page/{slug}',          [FRONTEND\HomeController::class,'page']);

Route::resource('install',    App\Http\Controllers\Installer\InstallerController::class);
Route::post('install/verify', [App\Http\Controllers\Installer\InstallerController::class,'verify'])->name('install.verify');
Route::post('install/migrate', [App\Http\Controllers\Installer\InstallerController::class,'migrate'])->name('install.migrate');

?>