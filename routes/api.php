<?php /** @noinspection ALL */

use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user();
});*/
Route::post('user/login', 'UserController@login');
Route::post('user/forgot/password', 'UserController@forgotPassword');

Route::group(['middleware' => ['subscription.auth']], function() {

    Route::get('subscription/list', 'SubscriptionController@index');
    Route::get('setting/detail', 'GeneralController@getSettingValue');
    Route::get('marketing/template/list', 'GeneralController@getMarketingMailTemplate');

    //Contact Us
    Route::post('user/contact', 'UserController@contactUs');

    //company
    Route::post('status/create', 'CompanyController@storeStatus');
    Route::post('lead/status/update', 'CompanyController@updateStatus');
    Route::post('type/create', 'CompanyController@storeType');
    Route::get('company/list', 'CompanyController@index');
    Route::get('status/list', 'CompanyController@statusList');
    Route::get('type/list', 'CompanyController@typeList');

    //user
    Route::get('user/list', 'UserController@index');
    Route::get('user/setting', 'UserController@getSetting');
    Route::post('user/update/setting', 'UserController@updateSetting');
    Route::post('user/update/location', 'UserController@updateLocation');
    Route::get('tenant/user/list', 'UserController@tenantUserList');
    Route::post('company/create', 'UserController@storeCompany');
    Route::post('inspector/create', 'UserController@storeInspector');
    Route::get('inspector/list', 'UserController@inspectorList');

    Route::post('agent/create', 'UserController@storeAgent');

    Route::get('user/detail', 'UserController@show');
    Route::get('user/profile', 'UserController@profile');
    Route::post('user/change/hash/password', 'UserController@changePasswordByHash');
    Route::post('user/change/password', 'UserController@changePassword');
    //Route::post('business/update', 'UserController@updateBusiness');
    //Route::post('agent/update', 'UserController@updateAgent');
    Route::post('user/update', 'UserController@updateAgent');
    Route::post('user/subscription', 'UserController@subscription');
    Route::get('user/subscription', 'UserController@userSubscription');

    Route::post('user/social', 'UserController@social');
    Route::post('comapny/donate', 'UserController@addCompanyDonation');
    Route::post('payment/process', 'UserController@paymentProcess');


    // User Group
    Route::get('companygroup/list', 'CompanyGroupController@index');
    Route::post('companygroup/store', 'CompanyGroupController@store');
    Route::post('companygroup/update/{id}', 'CompanyGroupController@update');
    Route::post('companygroup/delete/{id}', 'CompanyGroupController@delete');


    // Category
    Route::get('category/list', 'CategoryController@index');
    Route::post('category/store', 'CategoryController@store');
    Route::post('category/group/store', 'CategoryController@storeGroup');
    Route::post('category/update/{id}', 'CategoryController@update');
    Route::post('category/delete/{id}', 'CategoryController@delete');

    // Project
    Route::group(['prefix'=>'project','as'=>'project.'], function (){
        Route::post('store',  'ProjectShareController@store');

        Route::get('list', 'ProjectController@index');
        Route::get('list_all', 'ProjectController@listAll');
        Route::get('detail/{any}', 'ProjectController@detail');
        Route::get('images/{id}', 'ProjectController@images');
        Route::post('status/update/{id}', 'ProjectController@statusUpdate');
        Route::post('store', 'ProjectController@store');
        Route::post('storeComplete', 'ProjectController@storeComplete');
        Route::post('updateComplete/{id}', 'ProjectController@updateComplete');
        Route::post('imageSync', 'ProjectController@imageSync');
        Route::post('deleteImages', 'ProjectController@deleteImages');
        //Route::post('storeImages/{id}', 'ProjectController@storeImages');
        Route::post('storeImages/{project_id}/{category_id}', 'ProjectController@storeImages');
        Route::post('group/store', 'ProjectController@storeGroup');
        Route::post('update/{id}', 'ProjectController@update');
        Route::post('delete/{id}', 'ProjectController@delete');
        Route::post('create_report/{id}', 'ProjectController@createReport');
        Route::post('merge_report', 'ProjectController@mergeReport');
        Route::get('complete', 'ProjectController@complete');
//    Route::get('changes/updated', 'ProjectController@changesUpdated'); /* Isn't getting used 21-Jul-20 11:18 PM  */

        //Project Share
        Route::group(['prefix'=>'share','as'=>'share.'], function (){
            Route::post('store',  'ProjectShareController@store');
            Route::get('list',  'ProjectShareController@index');
            Route::get('detail/{id}',  'ProjectShareController@show');
            Route::get('update/{id}',  'ProjectShareController@update');
        });

    }); // end group project.

    // report
    Route::group(['prefix'=>'report','as'=>'report.'], function (){
        Route::post('create/{id}',  'ReportController@createReport');
        Route::get('list', 'CategoryController@getReportOptions');
        Route::get('list_v2/{id}', 'ReportController@getReportOptions');
        Route::post('sign', 'ReportController@addSign');
        Route::get('sign/customer', 'ReportController@sendCustomerSignMail');
    });


    Route::get('tag/list', 'TagController@index');

    // address
    Route::get('countries', 'GeneralController@getCountries');
    Route::get('states', 'GeneralController@getStates');
    Route::get('cities', 'GeneralController@getCities');

    //notification
    Route::get('notification/list', 'NotificationController@index');
    Route::get('notification/unread_count','NotificationController@unreadCount');
    Route::get('notification/update/{id}','NotificationController@update');
    Route::get('notification/delete_all','NotificationController@deleteAll');
    Route::get('notification/{id}', 'NotificationController@show');

    //notification settings
    Route::post('notification_setting', 'NotificationController@storeSetting');
    Route::get('notification_setting', 'NotificationController@getSetting');

    Route::get('query/list', 'QueryController@index');
    Route::post('query/response', 'QueryController@response');

    //CRM Routes
    Route::get('crm/project/detail/{any}', 'CrmProjectController@projectDetail');
    Route::post('crm/project/create', 'CrmProjectController@projectCreate');
    Route::get('crm/employee', 'CrmProjectController@getEmployee');
    Route::get('crm/employee/projects', 'CrmProjectController@getEmployeeProject');
    Route::get('crm/spec_list', 'CrmProjectController@getSpecList');
    Route::get('crm/project', 'CrmProjectController@getProject');
    Route::get('crm/project_media', 'CrmProjectController@getCrmMedia');

    Route::get('crm/sync', 'CrmProjectController@syncProject');

    // Eagle View
    Route::group(['prefix'=>'ev','as'=>'ev.'], function (){
        Route::get('set_products',  'EagleViewController@setProducts');
        Route::get('products',      'EagleViewController@productsList');
        Route::post('order_report', 'EagleViewController@orderReport');
        Route::get('fetch_report',  'EagleViewController@fetchReport');
    });

    // Hover
    Route::group(['prefix'=>'hover','as'=>'hover.'], function (){
        Route::get('hover_log',  'HoverController@hover_log');
        Route::post('create_job',  'HoverController@createJob');
        Route::get('get_measurements',  'HoverController@getMeasurements');
        Route::get('job_test_update',  'HoverController@jobTestUpdate');
        Route::get('get_measurements_report',  'HoverController@getMeasurementsReport');
        Route::get('get_sample_measurements',  'HoverController@getSampleMeasurements');

        // For debugging
        Route::get('get_users_list',  'HoverController@getHoverUsers');
    });



    Route::post('crm/add_project', 'CrmProjectController@addProject');
    Route::post('crm/add_images', 'CrmProjectController@addImages');

});