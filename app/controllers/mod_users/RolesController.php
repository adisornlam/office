<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com 
 */

namespace App\Controllers;

/**
 * Description of RoleController
 *
 * @author R-D-6
 */
class RolesController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('auth', array('except' => 'login'));
    }

    public function index() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data = array(
            'title' => 'รายการสิทธิ์ใช้งาน'
        );
        if (\Auth::check()) {
            if ($check->is('administrator')) {
                return \View::make('mod_users.admin.role.index', $data);
            } elseif ($check->is('employee')) {
                
            }
        } else {
            return \View::make('mod_users.guest.role', $data);
        }
    }

    public function listall() {
        $users = \Roles::select(array(
                    'id',
                    'name',
                    'description',
                    'level',
                    'created_at',
                    'updated_at'
        ));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="users/roles/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="users/roles/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($users)
                        ->edit_column('id', $link)
                        ->make(true);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            $data = array(
                'result_menu' => \Menu::where('sub_id', 0)->orderBy('rank')->get()
            );
            return \View::make('mod_users.admin.role.add', $data);
        } else {
            $rules = array(
                'name' => 'required',
                'level' => 'required|numeric'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $roles = new \Roles();
                $roles->name = trim(\Input::get('name'));
                $roles->description = trim(\Input::get('description'));
                $roles->level = trim(\Input::get('level'));
                $roles->save();
                if (\Input::get('menu_id') > 0) {
                    $roles->menu()->sync(\Input::get('menu_id'));
                }
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
                'item' => \Roles::find($param),
                'result_menu' => \Menu::where('sub_id', 0)->orderBy('rank')->get(),
                'result_menurole' => \Menurole::where('role_id', $param)->lists('menu_id')
            );
            return \View::make('mod_users.admin.role.edit', $data);
        } else {
            $rules = array(
                'name' => 'required',
                'level' => 'required|numeric'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $roles = \Roles::find(\Input::get('id'));
                $roles->name = trim(\Input::get('name'));
                $roles->description = trim(\Input::get('description'));
                $roles->level = trim(\Input::get('level'));
                $roles->save();
                if (\Input::get('menu_id') > 0) {
                    $roles->menu()->sync(\Input::get('menu_id'));
                }
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

}
