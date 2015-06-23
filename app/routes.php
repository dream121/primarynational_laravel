<?php

// Home Page Route
Route::get('/',array('as'=>'home','uses' => 'HomeController@getIndex'));


Route::group(['before' => 'guest'], function() {

    // Route for login/logout
    Route::get('login', array('as'=>'get-login','uses' => 'AuthController@getLogin'));
    Route::post('login', array('as'=>'post-login','uses' => 'AuthController@postLogin'));

    // Route for registration
    Route::get('register', array('as'=>'get-user-register', 'uses' => 'AuthController@getRegister'));
    Route::post('register', array('as'=>'post-user-register','uses' => 'AuthController@postRegister'));
    Route::post('register/member', array('as'=>'register-member','uses' => 'AuthController@postFreeMlsRegister'));


});

// Route for Property page
Route::get('property/{id}/{slug}', array('as'=>'get-property','uses' => 'PropertyController@getShow'))->where(array('id'=>'[0-9]+','slug'=>'[A-Za-z0-9-]+'));
Route::get('property/similar/{id}', array('as'=>'get-property-similar','uses' => 'PropertyController@getSimilar'))->where(array('id'=>'[0-9-]+'));
Route::any('property/suggest', array('as'=>'get-property-suggestion','uses'=>'PropertyController@getSuggest'));

// Route for Contact us
Route::get('contact-us',array('uses' => 'ContactController@getIndex'));
Route::post('contact-us',array('uses' => 'ContactController@postComment'));

// Route for Buy
Route::get('buy',array('uses' => 'BuyController@getIndex'));
Route::post('buy',array('uses' => 'BuyController@postIndex'));

// Route for Sell
Route::get('sell',array('uses' => 'SellController@getIndex'));
Route::post('sell',array('uses' => 'SellController@postIndex'));

// Route for Finance
Route::get('finance',array('uses' => 'FinanceController@getIndex'));
Route::post('finance',array('uses' => 'FinanceController@postIndex'));

// Route for Agents
Route::get('agents',array('as'=>'agents','uses' => 'AgentsController@getIndex'));
Route::get('agents/{id}/{slug}', array('as'=>'single-agent','uses' => 'AgentsController@getShow'))->where(array('id'=>'[0-9]+','slug'=>'[A-Za-z0-9-]+'));

// Route for Guide
Route::get('community-guides',array('as'=>'guides','uses' => 'CommunityGuideController@getIndex'));

Route::get('community-guides/{slug}',array('as'=>'guide','uses' => 'CommunityGuideController@getView'))->where('slug','[A-Za-z-]+');

// Route for search result using angular
Route::controller('search', 'SearchController');

// Route::controller('blog','BlogController');


Route::get('blog', array('uses' => 'BlogController@getIndex'));
Route::get('blog-archive', array('uses' => 'BlogController@getBlogArchive'));
Route::get('blog/{slug}', array('uses' => 'BlogController@getShow'))->where('slug', '[A-Za-z0-9-]+');
Route::post('blog/{slug}', array('uses' => 'BlogController@postComment'))->where('slug', '[A-Za-z0-9-]+');
Route::post('subscribe', array('uses' => 'BlogController@postSubscribe'));

Route::get('page/{slug}',array('as'=>'page','uses'=>'PageController@getShow'))->where('slug','[A-Za-z0-9-]+');

Route::post('visitor/send_request_email', array('as'=>'post-visitor-email','uses'=>'AccountController@send_request'));

Route::post('visitor/save-search', array('uses'=>'AccountController@postSaveSearch'));
Route::post('visitor/save-favorite', array('uses'=>'AccountController@postSaveFavorite'));
Route::post('visitor/delete-favorite', array('uses'=>'AccountController@postDeleteFavorite'));
Route::get('visitor/favorites', array('uses'=>'AccountController@getFavorites'));
Route::post('visitor/inquiry', array('uses'=>'AccountController@postInquiry'));

//Route to password reset
Route::post('forgot', array('uses'=>'RemindersController@postRemind'));
Route::get('reset/{token}', array('uses'=>'RemindersController@getReset'));
Route::post('reset', array('uses'=>'RemindersController@postReset'));

//Route to Activate User Account
Route::get('activate/{email}/{token}', array('uses'=>'AuthController@activate'));
//Route for suggest
Route::get('suggest',array('uses' => 'PropertyController@suggest'));

// Route group for Search API version
Route::group(array('prefix' => 'api/v1'), function()
{
    Route::resource('search','ListingController' /*,array('only' => array('index','show'))*/);
});


Route::group(array('before' => 'auth'), function()
{
    Route::get('logout', array('as'=>'logout','uses' => 'AuthController@getLogout'));
    Route::get('account',array('as'=>'my-account','uses'=>'AccountController@getIndex'));
    Route::post('account',array('as'=>'post-account','uses'=>'AccountController@postAccount'));
    Route::post('change_password',array('as'=>'post-change_password','uses'=>'AccountController@postChangePassword'));
    Route::get('notification',array('as'=>'my-notification','uses'=>'AccountController@getNotification'));
    Route::get('notification/delete/{id}',array('as'=>'delete-notification','uses'=>'AccountController@getDeleteNotification'));
});

// ===============================================
// ADMIN SECTION
// ===============================================

Route::get('admin', function(){
    return Redirect::to('admin/dashboard');
});

Route::group(array('prefix' => 'admin', 'before' => 'auth|admin'), function(){

    Route::controller('page', 'PagesController');
    Route::controller('dashboard', 'DashboardController');
    Route::controller('blogs', 'BlogsController');
    Route::controller('press', 'PressController');
    Route::controller('guide', 'GuidesController');
    Route::controller('upload', 'UploadController');
    Route::controller('resource', 'ResourceController');
    Route::controller('category', 'CategoryController');
    Route::controller('social_media', 'SocialMediaController');
    Route::controller('banner', 'BannerController');
    Route::get('welcome_note', array('uses' => 'WelcomeNoteController@getEdit'));
    Route::post('welcome_note', array('uses' => 'WelcomeNoteController@postEdit'));
    Route::get('buy', array('uses' => 'BuysController@getEdit'));
    Route::post('buy', array('uses' => 'BuysController@postEdit'));
    Route::get('sell', array('uses' => 'SellsController@getEdit'));
    Route::post('sell', array('uses' => 'SellsController@postEdit'));
    Route::get('finance', array('uses' => 'FinancesController@getEdit'));
    Route::post('finance', array('uses' => 'FinancesController@postEdit'));
    Route::controller('manage','ManageController');
    Route::controller('agent','AgentController');
//    Route::get('user/{recent}', array('uses' => 'UserController@getIndex'));
//    Route::get('user/reset_status/{id}/{status}', array('uses' => 'UserController@getResetStatus'));
    Route::controller('user','UserController');
    Route::controller('financial-agent','FinancialAgentController');
    Route::get('feedback/reset_status/{id}/{status}', array('uses' => 'FeedbackController@getResetStatus'));
    Route::get('feedback/category/{category}', array('uses' => 'FeedbackController@getIndexByCat'));
    Route::get('feedback/category/{category}/{new}', array('uses' => 'FeedbackController@getIndexByCat'));
    Route::controller('feedback','FeedbackController');
    Route::get('comment/{id}', array('uses' => 'CommentController@getIndex'));
    Route::get('comment/reset_status/{id}/{status}', array('uses' => 'CommentController@getResetStatus'));
    Route::controller('comment','CommentController');
    Route::get('profile', array('uses' => 'AccountsController@getIndex'));
    Route::post('profile', array('uses' => 'AccountsController@postAccount'));
    Route::post('change_password', array('uses' => 'AccountsController@postChangePassword'));
});

Route::get('/thumb', 'UtilController@thumb');
