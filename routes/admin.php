<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin as ADMIN;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','admin']], function (){

	Route::resource('plan', 	     			ADMIN\PlanController::class);
	Route::resource('role', 	     			ADMIN\RoleController::class);
	Route::resource('admin', 	     			ADMIN\AdminController::class);
	Route::resource('order', 	     			ADMIN\OrderController::class);
	Route::resource('customer',      			ADMIN\CustomerController::class);
	Route::resource('gateways',      			ADMIN\GatewayController::class);
	Route::resource('cron-job',      			ADMIN\CronjobController::class);
	Route::resource('page', 	     			ADMIN\PageController::class);
	Route::resource('blog', 	     			ADMIN\BlogController::class);
	Route::resource('category', 	     		ADMIN\CategoryController::class);
	Route::resource('tag', 	     		        ADMIN\TagController::class);
	Route::resource('language',      			ADMIN\LanguageController::class);
	Route::resource('menu', 	     			ADMIN\MenuController::class);
	Route::resource('page-settings', 			ADMIN\SettingsController::class);
	Route::resource('seo', 		     			ADMIN\SeoController::class);
	Route::resource('support', 	     			ADMIN\SupportController::class);
	Route::resource('notification',  			ADMIN\NotifyController::class);
	Route::resource('devices',       			ADMIN\DeviceController::class);
	Route::resource('apps',          			ADMIN\AppController::class);
	Route::resource('contacts',      			ADMIN\ContactsController::class);
	Route::resource('template',      			ADMIN\TemplateController::class);
	Route::resource('schedules',     			ADMIN\ScheduleController::class);
	Route::resource('features',     			ADMIN\FeaturesController::class);
	Route::resource('testimonials',     		ADMIN\TestimonialsController::class);
	Route::resource('faq',     		            ADMIN\FaqController::class);
	Route::resource('team',     		        ADMIN\TeamController::class);
	Route::resource('about',     		        ADMIN\AboutController::class);
	Route::resource('message-transactions',     ADMIN\TransactionController::class);
	//Route::resource('page-settings',     		ADMIN\PageSettingsController::class);
	Route::resource('app-settings',     		ADMIN\AppSettingsController::class);
	Route::resource('developer-settings',     	ADMIN\DeveloperSettingsController::class);
	Route::resource('partner',     				ADMIN\PartnerController::class);

	Route::get('dashboard', 					[ADMIN\DashboardController::class, 'index'])->name('dashboard.index');
	Route::post('/language/addkey',				[ADMIN\LanguageController::class, 'addKey']);
	Route::post('/menu-update/{id}',		    [ADMIN\MenuController::class, 'storeDate'])->name('menu.content.update');
	Route::get('profile', 						[ADMIN\ProfileController::class,'settings']);
	Route::put('profile/update/{type}', 		[ADMIN\ProfileController::class,'update'])->name('profile.update');
	Route::put('/option-update/{key}',		    [ADMIN\OptionController::class, 'update'])->name('option.update');
	Route::get('dashboard-static-data',         [ADMIN\DashboardController::class, 'dashboardData'])->name('dashboard.static');
	Route::get('/wa-server-status',				[ADMIN\DashboardController::class, 'waServerStatus']);
	Route::get('/sales-overview',				[ADMIN\DashboardController::class, 'salesOverView']);

});


?>