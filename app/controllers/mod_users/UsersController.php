<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com 
 */

namespace App\Controllers;

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
                return \View::make('mod_users.admin.users.index', $data);
            } elseif ($check->is('mis')) {
                return \View::make('mod_users.mis.users.index', $data);
            }
        } else {
            return \View::make('mod_users.guest.index', $data);
        }
    }

    public function listall() {
        $users = \DB::table('users')
                ->join('company', 'users.company_id', '=', 'company.id')
                ->join('department', 'users.department_id', '=', 'department.id')
                ->select(array(
            'users.id as id',
            'users.username as username',
            \DB::raw('CONCAT(users.firstname," ",users.lastname) as fullname'),
            'company.title as company',
            'department.title as department',
            'users.email as email',
            'users.mobile as mobile',
            'users.disabled',
            'users.created_at as created_at'
        ));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="' . \URL::to('users/view/{{$id}}') . '" title="แสดงรายการ"><i class="fa fa-eye"></i> แสดงรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="users/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
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
                'รายการผู้ใช้งาน' => 'users',
                'ข้อมูลส่วนตัว' => '#'
            ),
            'item' => \User::find($param),
            'address' => NULL
        );
        return \View::make('mod_users.admin.users.view', $data);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            return \View::make('mod_users.admin.users.add');
        } else {
            $rules = array(
                'company_id' => 'required',
                'department_id' => 'required',
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
                $user->company_id = \Input::get('company_id');
                $user->department_id = \Input::get('department_id');
                $user->codes = trim(\Input::get('codes'));
                $user->firstname = trim(\Input::get('firstname'));
                $user->lastname = trim(\Input::get('lastname'));
                $user->email = trim(\Input::get('email'));
                $user->mobile = trim(\Input::get('mobile'));
                $user->username = trim(\Input::get('username'));
                $user->password = trim(\Input::get('password'));
                $user->disabled = (\Input::has('disabled') ? 0 : 1);
                $user->verified = (\Input::has('verified') ? 1 : 0);
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
                'item' => \User::find($param)
            );
            return \View::make('mod_users.admin.users.edit', $data);
        } else {
            $rules = array(
                'company_id' => 'required',
                'department_id' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:users',
                'role_id' => 'required',
                'avatar' => 'image|mimes:jpeg,png|max:512',
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $photo1 = \Input::file('avatar');
                $destinationPath = 'uploads/users/' . date('Ymd') . '/';
                if ($photo1) {
                    $up = $this->upload_photo($photo1, $destinationPath);
                    $photo_1 = $up['resize'];
                } else {
                    $photo_1 = NULL;
                }
                $user = \User::find($param);
                $user->company_id = \Input::get('company_id');
                $user->department_id = \Input::get('department_id');
                $user->codes = trim(\Input::get('codes'));
                $user->firstname = trim(\Input::get('firstname'));
                $user->lastname = trim(\Input::get('lastname'));
                $user->email = trim(\Input::get('email'));
                $user->mobile = trim(\Input::get('mobile'));
                $user->disabled = (\Input::has('disabled') ? 0 : 1);
                $user->verified = (\Input::has('verified') ? 1 : 0);
                $user->avatar = $photo1;
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

    private function upload_photo($file, $path) {
        $extension = $file->getClientOriginalExtension();
        $filename = str_random(32) . '.' . $extension;
        $smallfile = 'resize_' . $filename;
        $file->move($path, $filename);
        $img = \Image::make($path . $filename);
        $img->resize(250, 270)->save($path . $smallfile);

        $photo = array(
            'full' => $path . $filename,
            'resize' => $path . $smallfile
        );
        return $photo;
    }

}
