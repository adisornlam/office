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
            'title' => 'รายการผู้ใช้งาน',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'รายการผู้ใช้งาน' => '#'
            ),
            'company' => \Company::lists('title', 'id')
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
                ->leftJoin('position_item', 'users.position_id', '=', 'position_item.id');
        if (\Input::has('company_id')) {
            $users->where('users.company_id', \Input::get('company_id'));
        }
        if (\Input::has('department_id')) {
            $users->where('users.department_id', \Input::get('department_id'));
        }
        if (\Input::has('disabled')) {
            $users->where('users.disabled', \Input::get('disabled'));
        }
        $users->select(array(
            'users.id as id',
            'users.username as username',
            'users.codes as codes',
            \DB::raw('CONCAT(users.firstname," ",users.lastname) as fullname'),
            'position_item.title as position',
            'users.email as email',
            'users.mobile as mobile',
            'company.title as company',
            'users.disabled'
        ));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="users/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="users/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($users)
                        ->edit_column('id', $link)
                        ->edit_column('username', function($result_obj) {
                            $str = '<a href="' . \URL::to('users/view/' . $result_obj->id . '') . '">' . $result_obj->username . '</a>';
                            return $str;
                        })
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
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        if (!\Request::isMethod('post')) {
            if ($check->is('administrator')) {
                return \View::make('mod_users.admin.users.add');
            } elseif ($check->is('mis')) {
                return \View::make('mod_users.mis.users.add');
            }
        } else {
            $rules = array(
                'company_id' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'codes' => 'unique:users',
                'email' => 'email|unique:users',
                'role_id' => 'required',
                'username' => 'unique:users',
                'password' => 'min:8'
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
                $user->position_id = \Input::get('position_id');
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
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        if (!\Request::isMethod('post')) {
            $item = \User::find($param);
            $role = \DB::table('role_user')->where('user_id', $param)->first();
            $data = array(
                'title' => 'แก้ไขข้อมูลส่วนตัว',
                'breadcrumbs' => array(
                    'รายการผู้ใช้งาน' => 'users',
                    'แก้ไขข้อมูลส่วนตัว' => '#'
                ),
                'item' => $item,
                'role_id' => (isset($role->role_id) ? $role->role_id : 0)
            );
            if ($check->is('administrator')) {
                return \View::make('mod_users.admin.users.edit', $data);
            } elseif ($check->is('mis')) {
                return \View::make('mod_users.mis.users.edit', $data);
            }
        } else {
            $rules = array(
                'company_id' => 'required',
                'firstname' => 'required',
                'lastname' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
//                $photo1 = \Input::file('avatar');
//                $destinationPath = 'uploads/users/' . date('Ymd') . '/';
//                if ($photo1) {
//                    $up = $this->upload_photo($photo1, $destinationPath);
//                    $photo_1 = $up['resize'];
//                } else {
//                    $photo_1 = NULL;
//                }
                $user = \User::find($param);
                $user->company_id = \Input::get('company_id');
                $user->department_id = \Input::get('department_id');
                $user->position_id = \Input::get('position_id');
                $user->codes = trim(\Input::get('codes'));
                $user->firstname = trim(\Input::get('firstname'));
                $user->lastname = trim(\Input::get('lastname'));
                $user->email = trim(\Input::get('email'));
                $user->mobile = trim(\Input::get('mobile'));
                $user->username = trim(\Input::get('username'));
                if (\Input::has('password')) {
                    $user->password = trim(\Input::get('password'));
                }
                $user->disabled = (\Input::has('disabled') ? 0 : 1);
                $user->verified = (\Input::has('verified') ? 1 : 0);
                $user->save();


                $user->roles()->sync(\Input::get('role_id'));

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
