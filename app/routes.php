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
Route::get('/', 'App\Controllers\HomeController@index');
Route::match(array('GET', 'POST'), 'login', array('uses' => 'App\Controllers\AuthenticationController@login'));
Route::get('logout', array('uses' => 'App\Controllers\AuthenticationController@logout'));

//Mod MIS
Route::group(array('prefix' => 'mis', 'before' => 'authen'), function() {
    Route::get('', 'App\Controllers\MisController@index');

    //computer
    Route::get('computer', 'App\Controllers\ComputerController@index');
    Route::get('computer/listall', 'App\Controllers\ComputerController@listall');
    Route::get('computer/dialog', 'App\Controllers\ComputerController@dialog');
    Route::match(array('GET', 'POST'), 'computer/add', array('uses' => 'App\Controllers\ComputerController@add'));
    Route::match(array('GET', 'POST'), 'computer/edit/{id}', array('uses' => 'App\Controllers\ComputerController@edit'));
    Route::get('computer/view/{id}', 'App\Controllers\ComputerController@view');
    Route::get('computer/delete/{id}', 'App\Controllers\ComputerController@delete');

    Route::get('hsware', 'App\Controllers\HswareController@index');
    Route::get('hsware/listall', 'App\Controllers\HswareController@listall');
    Route::get('hsware/dialog', 'App\Controllers\HswareController@dialog');
    Route::match(array('GET', 'POST'), 'hsware/add', array('uses' => 'App\Controllers\HswareController@add'));
    Route::match(array('GET', 'POST'), 'hsware/edit/{id}', array('uses' => 'App\Controllers\HswareController@edit'));
    Route::get('hsware/view/{id}', 'App\Controllers\HswareController@view');
    Route::get('hsware/delete/{id}', 'App\Controllers\HswareController@delete');

    Route::get('hsware/group', 'App\Controllers\HswareController@group');
    Route::get('hsware/group/listall', 'App\Controllers\HswareController@group_listall');
    Route::match(array('GET', 'POST'), 'hsware/group/add', array('uses' => 'App\Controllers\HswareController@group_add'));
    Route::match(array('GET', 'POST'), 'hsware/group/edit/{id}', array('uses' => 'App\Controllers\HswareController@group_edit'));
    Route::get('hsware/group/delete/{id}', 'App\Controllers\HswareController@group_delete');

    Route::get('hsware/group/model', 'App\Controllers\HswareController@model');
    Route::get('hsware/group/model/listall', 'App\Controllers\HswareController@model_listall');
    Route::match(array('GET', 'POST'), 'hsware/group/model/add', array('uses' => 'App\Controllers\HswareController@model_add'));
    Route::match(array('GET', 'POST'), 'hsware/group/model/edit/{id}', array('uses' => 'App\Controllers\HswareController@model_edit'));
    Route::get('hsware/group/model/delete/{id}', 'App\Controllers\HswareController@model_delete');

    //Testing
    Route::get('testing', 'App\Controllers\TestingController@group');
    Route::get('testing/group/listall', 'App\Controllers\TestingController@group_listall');
    Route::match(array('GET', 'POST'), 'testing/group/add', array('uses' => 'App\Controllers\TestingController@group_add'));
    Route::match(array('GET', 'POST'), 'testing/group/edit/{id}', array('uses' => 'App\Controllers\TestingController@group_edit'));

    Route::get('testing/view/{id}', 'App\Controllers\TestingController@view');
    Route::get('testing/view/listall/{id}', 'App\Controllers\TestingController@view_listall');

    Route::match(array('GET', 'POST'), 'testing/add', array('uses' => 'App\Controllers\TestingController@add'));
});

//users
Route::group(array('prefix' => 'users', 'before' => 'authen'), function() {
    Route::get('', 'App\Controllers\UsersController@index');
    Route::get('listall', 'App\Controllers\UsersController@listall');
    Route::match(array('GET', 'POST'), 'add', array('uses' => 'App\Controllers\UsersController@add'));
    Route::match(array('GET', 'POST'), 'edit/{id}', array('uses' => 'App\Controllers\UsersController@edit'));

    //roles
    Route::get('roles', 'App\Controllers\RolesController@index');
    Route::get('roles/listall', 'App\Controllers\RolesController@listall');
    Route::match(array('GET', 'POST'), 'roles/add', array('uses' => 'App\Controllers\RolesController@add'));
    Route::match(array('GET', 'POST'), 'roles/edit/{id}', array('uses' => 'App\Controllers\RolesController@edit'));

    //department
    Route::get('department', 'App\Controllers\DepartmentController@index');
    Route::get('department/sub/{id}', 'App\Controllers\DepartmentController@sub');
    Route::get('department/listall', 'App\Controllers\DepartmentController@listall');
    Route::match(array('GET', 'POST'), 'department/add', array('uses' => 'App\Controllers\DepartmentController@add'));
    Route::match(array('GET', 'POST'), 'department/edit/{id}', array('uses' => 'App\Controllers\DepartmentController@edit'));
    Route::match(array('GET', 'POST'), 'department/sub/add/{id}', array('uses' => 'App\Controllers\DepartmentController@sub_add'));
    Route::match(array('GET', 'POST'), 'department/sub/edit/{id}', array('uses' => 'App\Controllers\DepartmentController@sub_edit'));

    //company
    Route::get('company', 'App\Controllers\CompanyController@index');
    Route::get('company/listall', 'App\Controllers\CompanyController@listall');
    Route::match(array('GET', 'POST'), 'company/add', array('uses' => 'App\Controllers\CompanyController@add'));
    Route::match(array('GET', 'POST'), 'company/edit/{id}', array('uses' => 'App\Controllers\CompanyController@edit'));

    Route::get('view/{id}', 'App\Controllers\UsersController@view');
    Route::get('edit/{id}', 'App\Controllers\UsersController@edit');
});


//Domain
Route::group(array('prefix' => 'domain', 'before' => 'authen'), function() {
    Route::get('', 'App\Controllers\DomainController@index');
    Route::get('listall', 'App\Controllers\DomainController@listall');
    Route::match(array('GET', 'POST'), 'add', array('uses' => 'App\Controllers\DomainController@add'));
    Route::match(array('GET', 'POST'), 'edit/{id}', array('uses' => 'App\Controllers\DomainController@edit'));
    Route::get('delete/{id}', 'App\Controllers\DomainController@delete');

    Route::get('server', 'App\Controllers\ServerController@index');
    Route::get('server/listall', 'App\Controllers\ServerController@listall');
    Route::match(array('GET', 'POST'), 'server/add', array('uses' => 'App\Controllers\ServerController@add'));
    Route::match(array('GET', 'POST'), 'server/edit/{id}', array('uses' => 'App\Controllers\ServerController@edit'));
    Route::get('server/delete/{id}', 'App\Controllers\ServerController@delete');
});

//Contact
Route::group(array('prefix' => 'contact', 'before' => 'authen'), function() {
    Route::get('', 'App\Controllers\ContactController@index');
    Route::get('listall', 'App\Controllers\ContactController@listall');
    Route::match(array('GET', 'POST'), 'add', array('uses' => 'App\Controllers\ContactController@add'));
    Route::match(array('GET', 'POST'), 'edit/{id}', array('uses' => 'App\Controllers\ContactController@edit'));
    Route::get('delete/{id}', 'App\Controllers\ContactController@delete');

    Route::get('group', 'App\Controllers\ContactController@group');
    Route::get('group/listall', 'App\Controllers\ContactController@group_listall');
    Route::match(array('GET', 'POST'), 'group/add', array('uses' => 'App\Controllers\ContactController@group_add'));
    Route::match(array('GET', 'POST'), 'group/edit/{id}', array('uses' => 'App\Controllers\ContactController@group_edit'));
    Route::get('group/delete/{id}', 'App\Controllers\ContactController@group_delete');
});

//Menu
Route::group(array('prefix' => 'setting', 'before' => 'authen'), function() {
    Route::get('menu', 'App\Controllers\MenuController@index');
    Route::get('menu/listall', 'App\Controllers\MenuController@listall');
    Route::match(array('GET', 'POST'), 'menu/add/{id}', array('uses' => 'App\Controllers\MenuController@add'));
    Route::match(array('GET', 'POST'), 'menu/edit/{id}', array('uses' => 'App\Controllers\MenuController@edit'));
    Route::get('menu/delete/{id}', 'App\Controllers\MenuController@delete');

    Route::get('menu/sub/{id}', 'App\Controllers\MenuController@sub');
    Route::get('menu/sub/listall/{id}', 'App\Controllers\MenuController@listall');
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

Route::get('get/found_user_code', function() {
    $input = Input::get('user_code');
    $amphur_postcode = \DB::table('users')->where('title', 'LIKE', '%' . $input . '%');
    return Response::json($amphur_postcode->select(array('post_code', 'post_code'))->get());
});

Route::get('get/position', function() {
    $input = Input::get('option');
    $amphur = \DB::table('position_item')->where('company_id', $input)->orderBy('title');
    return Response::json($amphur->select(array('id', 'title'))->get());
});

// Display all SQL executed in Eloquent
//Event::listen('illuminate.query', function($query) {
//    var_dump($query);
//});
