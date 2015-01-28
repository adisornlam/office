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
class DepartmentController extends \BaseController {

    public function index() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data = array(
            'title' => 'รายการฝ่าย/แผนก'
        );
        if (\Auth::check()) {
            if ($check->is('administrator')) {
                return \View::make('backend.users.admin.department.index', $data);
            } elseif ($check->is('employee')) {
                
            }
        } else {
            return \View::make('backend.users.guest.department', $data);
        }
    }

    public function sub() {
        $segment = \Request::segment(5);
        $data = array(
            'title' => 'รายการฝ่าย/แผนก',
            'breadcrumbs' => array(
                'รายการฝ่าย/แผนก' => 'users/backend/department',
                'รายการแผนก' => '#'
            ),
            'sub_id' => ($segment > 0 ? $segment : 0)
        );
        return \View::make('backend.users.admin.department.sub', $data);
    }

    public function listall() {
        $id = (\Input::has('sub_id') != '' ? \Input::get('sub_id') : 0);
        $department = \Department::select(array(
                    'department.id',
                    'department.id as did',
                    'department.title',
                    'department.weight',
                    'department.disabled',
                    'department.created_at',
                    'department.updated_at'
                ))
                ->leftJoin('department_hierarchy', 'department.id', '=', 'department_hierarchy.department_id')
                ->where('department_hierarchy.department_parent_id', $id);
        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        if ($id <= 0) {
            $link .= '<li><a href="javascript:;" rel="users/backend/department/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        } else {
            $link .= '<li><a href="javascript:;" rel="users/backend/department/sub/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        }
        $link .= '<li><a href="javascript:;" rel="users/backend/department/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($department)
                        ->edit_column('id', $link)
                        ->edit_column('title', '<a href="' . \URL::to('users/backend/department/sub/{{$did}}') . '">{{$title}}</a>')
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            return \View::make('backend.users.admin.department.add');
        } else {
            $rules = array(
                'title' => 'required',
                'weight' => 'integer'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $department = new \Department();
                $department->title = trim(\Input::get('title'));
                $department->type = 'department';
                $department->description = trim(\Input::get('description'));
                $department->weight = trim(\Input::get('weight'));
                $department->disabled = (\Input::has('disabled') ? 0 : 1);
                $department->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function sub_add() {
        if (!\Request::isMethod('post')) {
            $segment = \Request::segment(6);
            $data = array(
                'sub_id' => $segment
            );
            return \View::make('backend.users.admin.department.sub_add', $data);
        } else {
            $rules = array(
                'title' => 'required'
            );
            $messages = array(
                'required' => 'กรุณากรอกช่อง:attribute',
            );
            $mLabel = array(
                'title' => 'แผนก'
            );
            $validator = \Validator::make(\Input::all(), $rules, $messages, $mLabel);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $department = new \Department();
                $department->title = trim(\Input::get('title'));
                $department->type = 'department';
                $department->description = trim(\Input::get('description'));
                $department->disabled = (\Input::has('disabled') ? 0 : 1);
                $department->save();
                $dep_id = $department->id;

                $dep_hichy = new \Departmenthierarchy();
                $dep_hichy->department_id = $dep_id;
                $dep_hichy->department_parent_id = \Input::get('sub_id');
                $dep_hichy->save();
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
                'item' => \Department::find($param),
            );
            return \View::make('backend.users.admin.department.edit', $data);
        } else {
            $rules = array(
                'title' => 'required'
            );
            $messages = array(
                'required' => 'กรุณากรอกช่อง:attribute',
            );
            $mLabel = array(
                'title' => 'แผนก'
            );
            $validator = \Validator::make(\Input::all(), $rules, $messages, $mLabel);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $department = \Department::find(\Input::get('id'));
                $department->title = trim(\Input::get('title'));
                $department->description = trim(\Input::get('description'));
                $department->weight = trim(\Input::get('weight'));
                $department->disabled = (\Input::has('disabled') ? 0 : 1);
                $department->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function sub_edit($param) {
        if (!\Request::isMethod('post')) {
            $dep = \Department::with('hierarchy')->where('Department.id', $param)->first();
            $data = array(
                'item' => $dep,
                'sub_id' => $dep->department_parent_id
            );
            return \View::make('backend.users.admin.department.sub_edit', $data);
        } else {
            $rules = array(
                'title' => 'required'
            );
            $messages = array(
                'required' => 'กรุณากรอกช่อง:attribute',
            );
            $mLabel = array(
                'title' => 'แผนก'
            );
            $validator = \Validator::make(\Input::all(), $rules, $messages, $mLabel);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $department = \Department::find(\Input::get('id'));
                $department->title = trim(\Input::get('title'));
                $department->description = trim(\Input::get('description'));
                $department->disabled = (\Input::has('disabled') ? 0 : 1);
                $department->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

}
