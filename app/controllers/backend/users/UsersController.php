<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com 
 */

namespace App\Controllers\Backend;

/**
 * Description of UsersController
 *
 * @author R-D-6
 */
class UsersController extends \BaseController {

    public function index() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data = array(
            'title' => 'รายการผู้ใช้งาน'
        );
        if (\Auth::check()) {
            if ($check->is('administrator')) {
                return \View::make('backend.users.admin.index', $data);
            } elseif ($check->is('employee')) {
                
            }
        } else {
            return \View::make('backend.users.guest.index', $data);
        }
    }

    public function listall() {
        $users = \User::select(array(
                    'users.id as id',
                    'users.username as username',
                    \DB::raw('CONCAT(users.firstname," ",users.lastname) as fullname'),
                    'users.email as email',
                    'users.mobile as mobile',
                    'users.disabled',
                    'users.created_at as created_at'
        ));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="' . \URL::to('users/backend/view/{{$id}}') . '" title="แสดงรายการ"><i class="fa fa-eye"></i> แสดงรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="users/backend/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($users)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function view($param) {
        $data = array(
            'title' => 'ข้อมูลส่วนตัว',
            'breadcrumbs' => array(
                'รายการผู้ใช้งาน' => 'users/backend',
                'ข้อมูลส่วนตัว' => '#'
            ),
            'item' => \User::find($param),
            'address' => \User::get_address($param)
        );
        return \View::make('backend.users.user_view', $data);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            return \View::make('backend.users.admin.user_add');
        } else {
            $rules = array(
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:users',
                'role_id' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required|min:8'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $user = new \User();
                $user->firstname = trim(\Input::get('firstname'));
                $user->lastname = trim(\Input::get('lastname'));
                $user->email = trim(\Input::get('email'));
                $user->mobile = trim(\Input::get('mobile'));
                $user->username = trim(\Input::get('username'));
                $user->password = trim(\Input::get('password'));
                $user->disabled = (\Input::has('disabled') ? 0 : 1);
                $user->verified = 1;
                $user->save();
                $user->roles()->sync(array(\Input::get('role_id')));
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function edit($param) {
        if (!\Request::isMethod('post')) {
            $data = array(
                'title' => 'แก้ไขข้อมูลส่วนตัว',
                'breadcrumbs' => array(
                    'รายการผู้ใช้งาน' => 'users/backend',
                    'แก้ไขข้อมูลส่วนตัว' => '#'
                ),
                'item' => \User::with('roles')->where('id', $param)->first(),
            );
            return \View::make('backend.users.user_edit', $data);
        } else {
            $rules = array(
                'firstname' => 'required',
                'lastname' => 'required',
                'address1' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $company = \User::find(\Input::get('id'));
                $company->title = trim(\Input::get('title'));
                $company->company_code = trim(\Input::get('company_code'));
                $company->address1 = trim(\Input::get('address1'));
                $company->address2 = trim(\Input::get('address2'));
                $company->district = \Input::get('district');
                $company->amphur = \Input::get('amphur');
                $company->province = \Input::get('province');
                $company->zipcode = \Input::get('zipcode');
                $company->email = trim(\Input::get('email'));
                $company->phone = trim(\Input::get('phone'));
                $company->fax = trim(\Input::get('fax'));
                $company->disabled = (\Input::has('disabled') ? 0 : 1);
                $company->updated_user = \Auth::user()->id;
                $company->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

}
