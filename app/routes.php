<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */
Route::get('/', 'App\Controllers\Backend\HomeController@index');
Route::get('backend', 'App\Controllers\Backend\HomeController@index');
Route::match(array('GET', 'POST'), 'backend/login', array('uses' => 'App\Controllers\Backend\AuthenticationController@login'));
Route::get('backend/logout', array('uses' => 'App\Controllers\Backend\AuthenticationController@logout'));

//Mod MIS
Route::group(array('prefix' => 'mis/backend', 'before' => 'authen'), function() {
    Route::get('', 'App\Controllers\Backend\MisController@index');

    Route::get('computer', 'App\Controllers\Backend\ComputerController@index');

    Route::get('hsware', 'App\Controllers\Backend\HswareController@index');    
    Route::get('hsware/listall', 'App\Controllers\Backend\HswareController@listall');    
    Route::get('hsware/dialog', 'App\Controllers\Backend\HswareController@dialog');
    Route::match(array('GET', 'POST'), 'hsware/add', array('uses' => 'App\Controllers\Backend\HswareController@add'));
    Route::match(array('GET', 'POST'), 'hsware/edit/{id}', array('uses' => 'App\Controllers\Backend\HswareController@edit'));
    Route::get('hsware/view/{id}', 'App\Controllers\Backend\HswareController@view');
    
    Route::get('hsware/group', 'App\Controllers\Backend\HswareController@group');
    Route::get('hsware/group/listall', 'App\Controllers\Backend\HswareController@group_listall');    
    Route::match(array('GET', 'POST'), 'hsware/group/add', array('uses' => 'App\Controllers\Backend\HswareController@group_add'));
    Route::match(array('GET', 'POST'), 'hsware/group/edit/{id}', array('uses' => 'App\Controllers\Backend\HswareController@group_edit'));
    Route::get('hsware/group/delete/{id}', 'App\Controllers\Backend\HswareController@group_delete');
});

//users
Route::group(array('prefix' => 'users/backend', 'before' => 'authen'), function() {
    Route::get('', 'App\Controllers\Backend\UsersController@index');
    Route::get('listall', 'App\Controllers\Backend\UsersController@listall');
    Route::match(array('GET', 'POST'), 'add', array('uses' => 'App\Controllers\Backend\UsersController@add'));
    Route::match(array('GET', 'POST'), 'edit/{id}', array('uses' => 'App\Controllers\Backend\UsersController@edit'));

    //roles
    Route::get('roles', 'App\Controllers\Backend\RolesController@index');
    Route::get('roles/listall', 'App\Controllers\Backend\RolesController@listall');
    Route::match(array('GET', 'POST'), 'roles/add', array('uses' => 'App\Controllers\Backend\RolesController@add'));
    Route::match(array('GET', 'POST'), 'roles/edit/{id}', array('uses' => 'App\Controllers\Backend\RolesController@edit'));

    //department
    Route::get('department', 'App\Controllers\Backend\DepartmentController@index');
    Route::get('department/sub/{id}', 'App\Controllers\Backend\DepartmentController@sub');
    Route::get('department/listall', 'App\Controllers\Backend\DepartmentController@listall');
    Route::match(array('GET', 'POST'), 'department/add', array('uses' => 'App\Controllers\Backend\DepartmentController@add'));
    Route::match(array('GET', 'POST'), 'department/edit/{id}', array('uses' => 'App\Controllers\Backend\DepartmentController@edit'));
    Route::match(array('GET', 'POST'), 'department/sub/add/{id}', array('uses' => 'App\Controllers\Backend\DepartmentController@sub_add'));
    Route::match(array('GET', 'POST'), 'department/sub/edit/{id}', array('uses' => 'App\Controllers\Backend\DepartmentController@sub_edit'));

    //company
    Route::get('company', 'App\Controllers\Backend\CompanyController@index');
    Route::get('company/listall', 'App\Controllers\Backend\CompanyController@listall');
    Route::match(array('GET', 'POST'), 'company/add', array('uses' => 'App\Controllers\Backend\CompanyController@add'));
    Route::match(array('GET', 'POST'), 'company/edit/{id}', array('uses' => 'App\Controllers\Backend\CompanyController@edit'));

    Route::get('view/{id}', 'App\Controllers\Backend\UsersController@view');
    Route::get('edit/{id}', 'App\Controllers\Backend\UsersController@edit');
});


//Domain
Route::group(array('prefix' => 'domain/backend', 'before' => 'authen'), function() {
    Route::get('', 'App\Controllers\Backend\DomainController@index');
    Route::get('listall', 'App\Controllers\Backend\DomainController@listall');
    Route::match(array('GET', 'POST'), 'add', array('uses' => 'App\Controllers\Backend\DomainController@add'));
    Route::match(array('GET', 'POST'), 'edit/{id}', array('uses' => 'App\Controllers\Backend\DomainController@edit'));
    Route::get('delete/{id}', 'App\Controllers\Backend\DomainController@delete');

    Route::get('server', 'App\Controllers\Backend\ServerController@index');
    Route::get('server/listall', 'App\Controllers\Backend\ServerController@listall');
    Route::match(array('GET', 'POST'), 'server/add', array('uses' => 'App\Controllers\Backend\ServerController@add'));
    Route::match(array('GET', 'POST'), 'server/edit/{id}', array('uses' => 'App\Controllers\Backend\ServerController@edit'));
    Route::get('server/delete/{id}', 'App\Controllers\Backend\ServerController@delete');
});

//Contact
Route::group(array('prefix' => 'contact/backend', 'before' => 'authen'), function() {
    Route::get('', 'App\Controllers\Backend\ContactController@index');
    Route::get('listall', 'App\Controllers\Backend\ContactController@listall');
    Route::match(array('GET', 'POST'), 'add', array('uses' => 'App\Controllers\Backend\ContactController@add'));
    Route::match(array('GET', 'POST'), 'edit/{id}', array('uses' => 'App\Controllers\Backend\ContactController@edit'));
    Route::get('delete/{id}', 'App\Controllers\Backend\ContactController@delete');

    Route::get('group', 'App\Controllers\Backend\ContactController@group');
    Route::get('group/listall', 'App\Controllers\Backend\ContactController@group_listall');
    Route::match(array('GET', 'POST'), 'group/add', array('uses' => 'App\Controllers\Backend\ContactController@group_add'));
    Route::match(array('GET', 'POST'), 'group/edit/{id}', array('uses' => 'App\Controllers\Backend\ContactController@group_edit'));
    Route::get('group/delete/{id}', 'App\Controllers\Backend\ContactController@group_delete');
});

//Menu
Route::group(array('prefix' => 'setting/backend', 'before' => 'authen'), function() {
    Route::get('menu', 'App\Controllers\Backend\MenuController@index');
    Route::get('menu/listall', 'App\Controllers\Backend\MenuController@listall');
    Route::match(array('GET', 'POST'), 'menu/add/{id}', array('uses' => 'App\Controllers\Backend\MenuController@add'));
    Route::match(array('GET', 'POST'), 'menu/edit/{id}', array('uses' => 'App\Controllers\Backend\MenuController@edit'));
    Route::get('menu/delete/{id}', 'App\Controllers\Backend\MenuController@delete');

    Route::get('menu/sub/{id}', 'App\Controllers\Backend\MenuController@sub');
    Route::get('menu/sub/listall/{id}', 'App\Controllers\Backend\MenuController@listall');
});


Route::get('get/amphur', function() {
    $input = Input::get('option');
    $amphur = \DB::table('amphur')->where('province_id', $input);
    return Response::json($amphur->select(array('amphur_id', 'amphur_name'))->get());
});

Route::get('get/district', function() {
    $input = Input::get('option');
    $district = \DB::table('district')->where('amphur_id', $input);
    return Response::json($district->select(array('district_id', 'district_name'))->get());
});

Route::get('get/zipcode', function() {
    $input = Input::get('option');
    $amphur_postcode = \DB::table('amphur_postcode')->where('amphur_id', $input);
    return Response::json($amphur_postcode->select(array('post_code', 'post_code'))->get());
});
