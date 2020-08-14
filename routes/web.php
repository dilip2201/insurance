<?php

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
    return redirect('/login');
});

Auth::routes();





/******************************* Admin login part start **********************************************/
Route::group(['middleware' => ['check-permission:super_admin|user|operator','checkactivestatus']], function () {
    
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        /***************** Profile *************************/
        Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@index']);

        /***************** Dashboard *************************/
        Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

        Route::group(['middleware' => 'check-permission:super_admin'], function () {
            /******************** User Dev : Dilip 15-06 ***********************/
            Route::resource('users', 'UserController');
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
                Route::post('getall', ['as' => 'getall', 'uses' => 'UserController@getall']);
                Route::post('getmodal', ['as' => 'getmodal', 'uses' => 'UserController@getmodal']);
                Route::post('changestatus', ['as' => 'changestatus', 'uses' => 'UserController@changestatus']);
            });
        });
        
        Route::group(['middleware' => 'check-permission:super_admin|user'], function () {
            /******************** Client Dev : vikas 20-06 ***********************/
            Route::resource('clients', 'ClientController');
            Route::group(['prefix' => 'clients', 'as' => 'clients.'], function () {
                Route::post('getall', ['as' => 'getall', 'uses' => 'ClientController@getall']);
                Route::post('changestatus', ['as' => 'changestatus', 'uses' => 'ClientController@changestatus']);
                Route::post('clientloadform', ['as' => 'clientloadform', 'uses' => 'ClientController@clientloadform']);
                Route::post('groupstore', ['as' => 'groupstore', 'uses' => 'ClientController@groupstore']);
                Route::post('groupload', ['as' => 'groupload', 'uses' => 'ClientController@groupload']);
                Route::post('selectgroup', ['as' => 'selectgroup', 'uses' => 'ClientController@selectgroup']);
                Route::post('viewdetail', ['as' => 'viewdetail', 'uses' => 'ClientController@viewdetail']);
                 Route::post('downloadpdf', ['as' => 'downloadpdf', 'uses' => 'ClientController@downloadpdf']);
                
                
            });
        });

        Route::group(['middleware' => 'check-permission:super_admin|user|operator'], function () {
            /******************** To Do Dev : vikas 21-06 ***********************/
            Route::resource('todos', 'ToDoController');
            Route::group(['prefix' => 'todos', 'as' => 'todos.'], function () {
                Route::post('getall', ['as' => 'getall', 'uses' => 'ToDoController@getall']);
                Route::post('changestatus', ['as' => 'changestatus', 'uses' => 'ToDoController@changestatus']);
                Route::post('getmodal', ['as' => 'getmodal', 'uses' => 'ToDoController@getmodal']);
                Route::post('getmodalhistory', ['as' => 'getmodalhistory', 'uses' => 'ToDoController@getmodalhistory']);
                Route::post('storelog', ['as' => 'storelog', 'uses' => 'ToDoController@storelog']);
                Route::post('getmodallog', ['as' => 'getmodallog', 'uses' => 'ToDoController@getmodallog']);
                Route::get('get_desc/{id}', ['as' => 'get_desc', 'uses' => 'ToDoController@get_desc']);
                Route::get('get_remark/{id}', ['as' => 'get_remark', 'uses' => 'ToDoController@get_remark']);
            });
        });

        Route::group(['middleware' => 'check-permission:super_admin|user'], function () {
            /******************** To Do Dev : vikas 27-06 ***********************/
            Route::resource('works', 'WorkController');
            Route::group(['prefix' => 'works', 'as' => 'works.'], function () {
                Route::post('getall', ['as' => 'getall', 'uses' => 'WorkController@getall']);
                Route::post('getmodal', ['as' => 'getmodal', 'uses' => 'WorkController@getmodal']);
                Route::post('companyload', ['as' => 'companyload', 'uses' => 'WorkController@companyload']);
                Route::post('workloadform', ['as' => 'workloadform', 'uses' => 'WorkController@workloadform']);
                Route::post('getcompanymodal', ['as' => 'getcompanymodal', 'uses' => 'WorkController@getcompanymodal']);
                Route::post('storecompany', ['as' => 'storecompany', 'uses' => 'WorkController@storecompany']);
                Route::post('changestatus', ['as' => 'changestatus', 'uses' => 'WorkController@changestatus']);
                Route::post('downloadpdf', ['as' => 'downloadpdf', 'uses' => 'WorkController@downloadpdf']);
            });
        });


        Route::group(['middleware' => 'check-permission:super_admin'], function () {
            /******************** Premium Report : vikas 21-07 ***********************/
            Route::resource('premiumreport', 'PremiumReportControler');
            Route::group(['prefix' => 'premiumreport', 'as' => 'premiumreport.'], function () {
                Route::post('getall', ['as' => 'getall', 'uses' => 'PremiumReportControler@getall']);
                Route::post('changestatus', ['as' => 'changestatus', 'uses' => 'PremiumReportControler@changestatus']);
                Route::post('getmodallog', ['as' => 'getmodallog', 'uses' => 'PremiumReportControler@getmodallog']);
                Route::post('storelog', ['as' => 'storelog', 'uses' => 'PremiumReportControler@storelog']);
                Route::post('getmodalhistory', ['as' => 'getmodalhistory', 'uses' => 'PremiumReportControler@getmodalhistory']);

            });

        });

        Route::group(['middleware' => 'check-permission:super_admin|user'], function () {
            /******************** Premium Report : vikas 21-07 ***********************/
            Route::resource('group', 'GroupController');
            Route::group(['prefix' => 'group', 'as' => 'group.'], function () {
                Route::post('getall', ['as' => 'getall', 'uses' => 'GroupController@getall']);
                Route::post('getmodal', ['as' => 'getmodal', 'uses' => 'GroupController@getmodal']);
                Route::post('delete', ['as' => 'delete', 'uses' => 'GroupController@delete']);
            });

        });


        Route::group(['middleware' => 'check-permission:super_admin'], function () {
            /******************** Report Dev : vikas 22-07 ***********************/
            Route::resource('report', 'ReportController');
            Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
               Route::post('downloadpdf', ['as' => 'downloadpdf', 'uses' => 'ReportController@downloadpdf']);
            });

        });


        /*********************** In out past date setting*********************************/
        Route::get('setting', ['as' => 'setting', 'uses' => 'SettingController@index']);
        Route::post('setting', ['as' => 'setting.store', 'uses' => 'SettingController@store']);
        /***************************** users *****************************************/
        Route::get('demo', ['as' => 'demo', 'uses' => 'DemoController@index']);

    });
    /**************** employee login part***************/

});

/***************************** Company login part end **************************************************/


/********************** common *********************/
Route::post('state', ['as' => 'public.state', 'uses' => 'PublicAccessController@state']);
Route::post('city', ['as' => 'public.city', 'uses' => 'PublicAccessController@city']);
Route::post('citywithstatecountry', ['as' => 'public.citywithstatecountry', 'uses' => 'PublicAccessController@citywithstatecountry']);

Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@index']);
Route::post('/profileupdate', ['as' => 'profileupdate', 'uses' => 'ProfileController@profileupdate']);
Route::post('/changepassword', ['as' => 'changepassword', 'uses' => 'ProfileController@changepassword']);
/********************** common *********************/

