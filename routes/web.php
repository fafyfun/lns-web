<?php

///use Auth;
//use App\Course;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {

   //dd(explode("/",url('')));

    //dd($_SERVER['REMOTE_HOST']);
//    $data = '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';
//    $image = base64_decode($data);
//    $f = finfo_open();
//
//    $mime_type = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
//
//    dd($mime_type);
    return redirect('home');

});


/*
 * Laravel default authentication routes
 * */
Auth::routes();

/*
 * after logging into the system the route to redirect
 * */
Route::get('/home', 'HomeController@index')->name('home');

/*
 * routes for the users of the console
 * */
Route::get('/users', 'UserController@index');
Route::get('/users/{user}/edit', 'UserController@edit');
Route::put('/users/{user}', 'UserController@update');
Route::delete('/deleteusers', 'UserController@destroy');

/*
 * routes for the roles
 * */
Route::get('/roles', 'RoleController@index');
Route::get('/roles/create', 'RoleController@create');
Route::post('/roles', 'RoleController@store');
Route::get('/roles/{role}/edit', 'RoleController@edit');
Route::put('/roles/{role}', 'RoleController@update');
Route::delete('/deleteroles', 'RoleController@destroy');

/*
 * routes for the role_user
 * */
Route::get('/roleuser', 'RoleUserController@index');
Route::get('/roleuser/create', 'RoleUserController@create');
Route::post('/roleuser', 'RoleUserController@store');
//Route::get('/roleuser/{role}/{user}/edit', 'RoleUserController@edit');
//Route::put('/roleuser/{role}/{user}', 'RoleUserController@update');
Route::delete('/deleteroleuser', 'RoleUserController@destroy');

/*
 * routes for the permission
 * */
Route::get('/permissions', 'PermissionController@index');
Route::get('/permissions/create', 'PermissionController@create');
Route::post('/permissions', 'PermissionController@store');
Route::get('/permissions/{permission}/edit', 'PermissionController@edit');
Route::put('/permissions/{permission}', 'PermissionController@update');
Route::delete('/deletepermissions', 'PermissionController@destroy');

/*
 * routes for the role_user
 * */
Route::get('/permissionrole', 'PermissionRoleController@index');
Route::get('/permissionrole/create', 'PermissionRoleController@create');
Route::post('/permissionrole', 'PermissionRoleController@store');
//Route::get('/permissionrole/{permission}/{role}/edit', 'PermissionRoleController@edit');
//Route::put('/permissionrole/{permission}/{role}', 'PermissionRoleController@update');
Route::delete('/deletepermissionrole', 'PermissionRoleController@destroy');

Route::get('/categories', 'CategoryController@index');
Route::get('/categories/create', 'CategoryController@create');
Route::post('/categories', 'CategoryController@store');
Route::get('/categories/{category}/edit', 'CategoryController@edit');
Route::put('/categories/{category}', 'CategoryController@update');
Route::delete('/deletecategories', 'CategoryController@destroy');

Route::get('/brands', 'BrandController@index');
Route::get('/brands/create', 'BrandController@create');
Route::post('/brands', 'BrandController@store');
Route::get('/brands/{brand}/edit', 'BrandController@edit');
Route::put('/brands/{brand}', 'BrandController@update');
Route::delete('/deletebrands', 'BrandController@destroy');

Route::get('/products', 'ProductController@index');
Route::get('/products/create', 'ProductController@create');
Route::post('/products', 'ProductController@store');
Route::get('/products/{product}/edit', 'ProductController@edit');
Route::get('/products/{product}/detail', 'ProductController@detail');
Route::put('/products/{product}', 'ProductController@update');
Route::delete('/deleteproducts', 'ProductController@destroy');


Route::get('/leadorinquiry/create', 'LeadOrInquiryController@create');
Route::post('/leadorinquiry', 'LeadOrInquiryController@store');

Route::post('/getCustomerEmails', 'LeadOrInquiryController@getCustomerEmails');
Route::post('/getCustomerDetails', 'LeadOrInquiryController@getCustomerDetails');
Route::post('/getAgents', 'LeadOrInquiryController@getAgents');

Route::get('/leads', 'SalesLeadController@index');

Route::post('/converttoinquiry/{lead}', 'InquiryController@convert');

Route::get('/inquiries', 'InquiryController@index');
Route::get('/inquiries/{inquiry}/view', 'InquiryController@view');
Route::get('/inquiries/{inquiry}/reschedule', 'InquiryController@canReschedule');
Route::put('/inquiries/{inquiry}', 'InquiryController@reschedule');

Route::get('/salestarget', 'SalesTargetController@index');
Route::get('/salestarget/create', 'SalesTargetController@create');
Route::post('/salestarget', 'SalesTargetController@store');
Route::get('/salestarget/{agent_id}/{year}/edit', 'SalesTargetController@edit');
Route::put('/salestarget/{agent_id}/{year}', 'SalesTargetController@update');

Route::get('/quotations', 'QuotationController@index');
Route::get('/quotations/{quotation}/detail', 'QuotationController@detail');
Route::post('/quotations/{quotation}/approve', 'QuotationController@approve');
Route::post('/getinstallationleads', 'QuotationController@getInstallationLeads');
Route::get('/quotations/email', 'QuotationController@email');
Route::get('/quotations/loademail', 'QuotationController@loadEmail');
//Route::get('/brands/create', 'BrandController@create');
//Route::post('/brands', 'BrandController@store');
//Route::get('/brands/{brand}/edit', 'BrandController@edit');
//Route::put('/brands/{brand}', 'BrandController@update');
//Route::delete('/deletebrands', 'BrandController@destroy');

Route::get('/jobs', 'JobController@index');
Route::get('/installations/{installation}/view', 'InstallationController@view');



Route::get('/activities/deleted/{subject}', 'ActivityController@deleted');

Route::get('/activities/{subjectId}/{subjectType}', 'ActivityController@index');

Route::get('/search/{subject}', 'SearchController@search');
























