<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User as USER;

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth','user','saas']], function (){
   
   //all dashboard routes
   Route::get('dashboard',                       [USER\DashboardController::class, 'index'])->name('dashboard.index');
   Route::get('dashboard-static-data',           [USER\DashboardController::class, 'dashboardData'])->name('dashboard.static');
   Route::get('messages-transaction/{days}',     [USER\DashboardController::class, 'getMessagesTransaction'])->name('messages.static');
   Route::get('chatbot-transaction/{days}',      [USER\DashboardController::class, 'getChatbotTransaction'])->name('chatbot.static');
   Route::get('messages-types-transaction/{days}', [USER\DashboardController::class, 'messagesStatics'])->name('types.static');

   //device routes
   Route::resource('device',                    USER\DeviceController::class);
   Route::get('device/{id}/qr',                 [USER\DeviceController::class,'scanQr'])->name('device.scan');
   Route::post('create-session/{id}',           [USER\DeviceController::class,'getQr']);
   Route::post('check-session/{id}',            [USER\DeviceController::class,'checkSession']);
   Route::post('/logout-session/{id}',          [USER\DeviceController::class,'logoutSession']);
   Route::post('/device-statics',               [USER\DeviceController::class,'deviceStatics']);
  
   Route::get('/device/chats/{uuid}',           [USER\ChatController::class,'chats']);
   Route::post('/get-chats/{uuid}',             [USER\ChatController::class,'chatHistory']);
   Route::post('/send-message/{uuid}',          [USER\ChatController::class,'sendMessage'])->middleware('throttle:5,1')->name('chat.send-message');

   Route::get('/device/groups/{uuid}',          [USER\ChatController::class,'groups']);
   Route::post('/get-groups/{uuid}',            [USER\ChatController::class,'groupHistory']);
   Route::post('/send-group-message/{uuid}',    [USER\ChatController::class,'sendGroupMessage'])->middleware('throttle:5,1')->name('group.send-message');

   //app routes
   Route::resource('apps',                      USER\AppsController::class);
   Route::get('/app/integration/{uuid}',        [USER\AppsController::class,'integration'])->name('app.integration');
   Route::get('/app/messages-logs/{uuid}',      [USER\AppsController::class,'logs'])->name('app.logs');

   //template routes
   Route::resource('template',                  USER\TemplateController::class);
   Route::post('/template/store/{type}',        [USER\TemplateController::class,'store'])->middleware('throttle:5,1')->name('template.store-now');

   //single send or custom text routes
   Route::get('/sent-text-message',                [USER\CustomTextController::class,'index']);
   Route::post('/sent-whatsapp-custom-text/{type}',[USER\CustomTextController::class,'sentCustomText'])->middleware('throttle:5,1')->name('sent.customtext');

   //bulk sender routes
   Route::post('/bulk-messages',                          [USER\BulkController::class,'store'])->middleware('throttle:1,1')->name('bulk-message.store');
   Route::resource('/bulk-message',                       USER\BulkController::class);
   Route::get('bulk-message/template-with-message/create',[USER\BulkController::class,'templateWithMessage']);
   Route::get('/sent-bulk-with-template/{id}/{deviceid}', [USER\BulkController::class,'sendBulkToContacts']);
   Route::post('/sent-message-with-template',             [USER\BulkController::class,'sendMessageToContact']);
   //schedule message routes
   Route::resource('schedule-message',                    USER\ScheduleController::class);
   //schedule message routes
   Route::resource('contact',                             USER\ContactController::class);
   Route::post('contact',                                 [USER\ContactController::class,'sendtemplateBulk'])->name('contact.send-template-bulk');
   Route::post('contact/store',                           [USER\ContactController::class,'store'])->name('contact.store');
   //chatbot route
   Route::resource('chatbot',                             USER\ChatbotController::class);
   //log report route
   Route::resource('logs',                                USER\LogController::class);
   //profile settings
   Route::get('profile',                                 [USER\ProfileController::class,'settings']);
   Route::put('profile/update/{type}',                   [USER\ProfileController::class,'update'])->name('profile.update');
   Route::get('auth-key',                                [USER\ProfileController::class,'authKey']);
   //help and support routes
   Route::resource('support',                            USER\SupportController::class);
   //subscription / plan route
   Route::resource('subscription',                       USER\SubscriptionController::class);
   Route::post('make-subscribe/{gateway_id}/{plan_id}',  [USER\SubscriptionController::class,'subscribe'])->name('make-payment');
   Route::get('/subscription/plan/{status}',             [USER\SubscriptionController::class,'status']);
   Route::get('/subscriptions/log',                      [USER\SubscriptionController::class,'log']);
   Route::resource('notifications',                      USER\NotificationController::class);

});




?>