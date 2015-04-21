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
    Route::get('computer/dialog_notebook', 'App\Controllers\ComputerController@dialog_notebook');
    Route::match(array('GET', 'POST'), 'computer/add', array('uses' => 'App\Controllers\ComputerController@add'));
    Route::match(array('GET', 'POST'), 'computer/add_wizard', array('uses' => 'App\Controllers\ComputerController@add_wizard'));
    Route::match(array('GET', 'POST'), 'computer/add_notebook_wizard', array('uses' => 'App\Controllers\ComputerController@add_notebook_wizard'));
    Route::match(array('GET', 'POST'), 'computer/edit/{id}', array('uses' => 'App\Controllers\ComputerController@edit'));
    Route::get('computer/view/{id}', 'App\Controllers\ComputerController@view');
    Route::get('computer/delete/{id}', 'App\Controllers\ComputerController@delete');
    Route::get('computer/deleteuser/{id}', 'App\Controllers\ComputerController@deleteuser');

    Route::get('computer/export/{id}', 'App\Controllers\ComputerController@export');

    //hsware
    Route::get('hsware', 'App\Controllers\HswareController@index');
    Route::get('hsware/listall', 'App\Controllers\HswareController@listall');
    Route::get('hsware/dialog', 'App\Controllers\HswareController@dialog');
    Route::match(array('GET', 'POST'), 'hsware/add', array('uses' => 'App\Controllers\HswareController@add'));
    Route::match(array('GET', 'POST'), 'hsware/edit/{id}', array('uses' => 'App\Controllers\HswareController@edit'));
    Route::get('hsware/view/{id}', 'App\Controllers\HswareController@view');
    Route::get('hsware/delete/{id}', 'App\Controllers\HswareController@delete');

    //software
    Route::get('software', 'App\Controllers\SoftwareController@index');
    Route::get('software/listall', 'App\Controllers\SoftwareController@listall');
    Route::match(array('GET', 'POST'), 'software/add', array('uses' => 'App\Controllers\SoftwareController@add'));
    Route::match(array('GET', 'POST'), 'software/edit/{id}', array('uses' => 'App\Controllers\SoftwareController@edit'));
    Route::get('software/delete/{id}', 'App\Controllers\SoftwareController@delete');
    Route::get('software/group', 'App\Controllers\SoftwareController@group');
    Route::get('software/group/listall', 'App\Controllers\SoftwareController@group_listall');
    Route::match(array('GET', 'POST'), 'software/group/add', array('uses' => 'App\Controllers\SoftwareController@group_add'));
    Route::match(array('GET', 'POST'), 'software/group/edit/{id}', array('uses' => 'App\Controllers\SoftwareController@group_edit'));
    Route::get('software/group/delete/{id}', 'App\Controllers\SoftwareController@group_delete');

    Route::get('hsware/group', 'App\Controllers\HswareController@group');
    Route::get('hsware/group/listall', 'App\Controllers\HswareController@group_listall');
    Route::match(array('GET', 'POST'), 'hsware/group/add', array('uses' => 'App\Controllers\HswareController@group_add'));
    Route::match(array('GET', 'POST'), 'hsware/group/edit/{id}', array('uses' => 'App\Controllers\HswareController@group_edit'));
    Route::get('hsware/group/delete/{id}', 'App\Controllers\HswareController@group_delete');

    Route::get('hsware/group/model', 'App\Controllers\HswareController@model');
    Route::get('hsware/group/model/listall', 'App\Controllers\HswareController@model_listall');
    Route::get('hsware/group/model/sub/{id}', 'App\Controllers\HswareController@model_sub');
    Route::get('hsware/group/model/sub/listall/{id}', 'App\Controllers\HswareController@model_sub_listall');
    Route::match(array('GET', 'POST'), 'hsware/group/model/add', array('uses' => 'App\Controllers\HswareController@model_add'));
    Route::match(array('GET', 'POST'), 'hsware/group/model/sub/add/{id}', array('uses' => 'App\Controllers\HswareController@model_sub_add'));
    Route::match(array('GET', 'POST'), 'hsware/group/model/dialog/add', array('uses' => 'App\Controllers\HswareController@model_dialog_add'));
    Route::match(array('GET', 'POST'), 'hsware/group/model/dialog/wizard/add', array('uses' => 'App\Controllers\HswareController@model_dialog_wizard_add'));
    Route::match(array('GET', 'POST'), 'hsware/group/model/edit/{id}', array('uses' => 'App\Controllers\HswareController@model_edit'));
    Route::match(array('GET', 'POST'), 'hsware/group/model/sub/edit/{id}', array('uses' => 'App\Controllers\HswareController@model_sub_edit'));
    Route::get('hsware/group/model/delete/{id}', 'App\Controllers\HswareController@model_delete');
    Route::get('hsware/group/model/sub/delete/{id}', 'App\Controllers\HswareController@model_sub_delete');

    Route::get('hsware/export/{id}', 'App\Controllers\HswareController@export');

    //Testing
    Route::get('testing', 'App\Controllers\TestingController@group');
    Route::get('testing/group/listall', 'App\Controllers\TestingController@group_listall');
    Route::match(array('GET', 'POST'), 'testing/group/add', array('uses' => 'App\Controllers\TestingController@group_add'));
    Route::match(array('GET', 'POST'), 'testing/group/edit/{id}', array('uses' => 'App\Controllers\TestingController@group_edit'));

    Route::get('testing/view/{id}', 'App\Controllers\TestingController@view');
    Route::get('testing/view/listall/{id}', 'App\Controllers\TestingController@view_listall');

    Route::match(array('GET', 'POST'), 'testing/add', array('uses' => 'App\Controllers\TestingController@add'));

    //supplier
    Route::get('supplier', 'App\Controllers\SupplierController@index');
    Route::get('supplier/listall', 'App\Controllers\SupplierController@listall');
    Route::match(array('GET', 'POST'), 'supplier/add', array('uses' => 'App\Controllers\SupplierController@add'));
    Route::match(array('GET', 'POST'), 'supplier/edit/{id}', array('uses' => 'App\Controllers\SupplierController@edit'));
    Route::get('supplier/delete/{id}', 'App\Controllers\SupplierController@delete');

    //pr
    Route::get('purchaserequest', 'App\Controllers\PurchaseRequestController@index');
    Route::get('purchaserequest/listall', 'App\Controllers\PurchaseRequestController@listall');
    Route::match(array('GET', 'POST'), 'purchaserequest/add', array('uses' => 'App\Controllers\PurchaseRequestController@add'));
    Route::match(array('GET', 'POST'), 'purchaserequest/edit/{id}', array('uses' => 'App\Controllers\PurchaseRequestController@edit'));
    Route::get('purchaserequest/delete/{id}', 'App\Controllers\PurchaseRequestController@delete');
    Route::get('purchaserequest/tmp/add', 'App\Controllers\PurchaseRequestController@tmp_add');

    //repairing
    Route::get('repairing', 'App\Controllers\RepairingController@index');
    Route::get('repairing/listall', 'App\Controllers\RepairingController@listall');
    Route::match(array('GET', 'POST'), 'repairing/add', array('uses' => 'App\Controllers\RepairingController@add'));
    Route::match(array('GET', 'POST'), 'repairing/edit/{id}', array('uses' => 'App\Controllers\RepairingController@edit'));
    Route::get('repairing/view/{id}', 'App\Controllers\RepairingController@view');
    Route::post('repairing/view/{id}', 'App\Controllers\RepairingController@send_repairing');
    Route::post('repairing/update/rating/{id}', 'App\Controllers\RepairingController@update_rating');
    Route::get('repairing/receive/{id}', 'App\Controllers\RepairingController@receive');
    Route::get('repairing/delete/{id}', 'App\Controllers\SupplierController@delete');

    Route::get('repairing/ma', 'App\Controllers\RepairingController@ma');
    Route::get('repairing/ma/listall', 'App\Controllers\RepairingController@ma_listall');
    Route::get('repairing/ma/dialog', 'App\Controllers\RepairingController@ma_dialog');
    Route::match(array('GET', 'POST'), 'repairing/ma/add', array('uses' => 'App\Controllers\RepairingController@ma_add'));
});

//WHS
Route::group(array('prefix' => 'whs', 'before' => 'authen'), function() {
    Route::get('', 'App\Controllers\WarehouseController@index');
    Route::get('listall', 'App\Controllers\WarehouseController@listall');
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

//Oil Service
Route::group(array('prefix' => 'oilservice', 'before' => 'authen'), function() {
    Route::get('', 'App\Controllers\OilController@index');
    Route::get('analysis', 'App\Controllers\OilController@analysis');
    Route::get('analysis/listall', 'App\Controllers\OilController@analysis_listall');
    Route::match(array('GET', 'POST'), 'analysis/add', array('uses' => 'App\Controllers\OilController@add'));
    Route::post('analysis/save', 'App\Controllers\OilController@analysis_save');
    Route::match(array('GET', 'POST'), 'analysis/edit/{id}', array('uses' => 'App\Controllers\OilController@edit'));
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

Route::get('get/department', function() {
    $input = Input::get('option');
    $department_id = \DB::table('department_item')->where('company_id', $input)->orderBy('title');
    return Response::json($department_id->select(array('id', 'title'))->get());
});

Route::get('get/position', function() {
    $input = Input::get('option');
    $position_id = \DB::table('position_item')->where('department_id', $input)->orderBy('title');
    return Response::json($position_id->select(array('id', 'title'))->get());
});

Route::get('get/getmodel', function() {
    $input = Input::get('option');
    $hsware_group = \DB::table('hsware_model')
            ->where('group_id', $input)
            ->orderBy('title');
    return Response::json($hsware_group->select(array('id', 'title'))->get());
});

Route::get('get/submodel', function() {
    $input = Input::get('option');
    $hsware_group = \DB::table('hsware_model')
            ->join('hsware_model_hierarchy', 'hsware_model.id', '=', 'hsware_model_hierarchy.hsware_model_id')
            ->where('hsware_model_hierarchy.hsware_model_parent_id', $input)
            ->orderBy('hsware_model.title');
    return Response::json($hsware_group->select(array('hsware_model.id', 'hsware_model.title'))->get());
});

Route::get('get/userddl', function() {
    $input = Input::get('option');
    $users = \DB::table('users')
            ->where('department_id', $input);
    $users->select(array(
        'id',
        \DB::raw('CONCAT(firstname," ",lastname) as title')
    ));
    return Response::json($users->get());
});

Route::get('get/hswareddl', function() {
    $input = Input::get('option');
    $company_id = Input::get('company_id');
    $reparing_publem = \RepairingPublem::find($input);
    $hsware_item = \DB::table('hsware_item')
            ->where('group_id', $reparing_publem->group_ref_id)
            ->where('spare', 1)
            ->where('company_id', $company_id);
    $hsware_item->select(array(
        'id',
        \DB::raw('CONCAT(serial_code) as title')
    ));
    return Response::json($hsware_item->get());
});

Route::get('get/getSerialCode', function() {

    $item = \DB::table('hsware_item')
            ->where('company_id', Input::get('company_id'))
            ->where('group_id', Input::get('group_id'))
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->first();

    if ($item) {
        if ($item->serial_code != NULL) {
            $str = explode("-", $item->serial_code);
            $sl = $str[2] + 1;
        } else {
            $sl = 1;
        }
    } else {
        $sl = 1;
    }
    $company = \Company::find(Input::get('company_id'));
    $group = \HswareGroup::find(Input::get('group_id'));

    return $company->company_code . '-' . $group->code_no . '-' . str_pad($sl, 3, "0", STR_PAD_LEFT);
});

Route::get('get/getSerialCom', function() {

    $item = \DB::table('computer_item')
            ->where('company_id', Input::get('company_id'))
            ->where('deleted_at', null)
            ->where('type_id', 1)
            ->orderBy('id', 'desc')
            ->select(array('serial_code'))
            ->first();
    $str = explode("-", $item->serial_code);
    $company = \Company::find(Input::get('company_id'));

    $sr = $str[2] + 1;

    return $company->company_code . '-C-' . str_pad($sr, 3, "0", STR_PAD_LEFT);
});

Route::get('get/getSerialNotebook', function() {

    $item = \DB::table('computer_item')
            ->where('company_id', Input::get('company_id'))
            ->where('deleted_at', null)
            ->where('type_id', 2)
            ->orderBy('serial_code', 'desc')
            ->select(array('serial_code'))
            ->first();
    if ($item) {
        $str = explode("-", $item->serial_code);
    } else {
        $str[2] = 0;
    }
    $company = \Company::find(Input::get('company_id'));

    $sr = $str[2] + 1;

    return $company->company_code . '-NB-' . str_pad($sr, 3, "0", STR_PAD_LEFT);
});

// Display all SQL executed in Eloquent
//Event::listen('illuminate.query', function($query) {
//    var_dump($query);
//});
