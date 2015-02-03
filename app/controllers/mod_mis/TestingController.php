<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com
 */

namespace App\Controllers;

/**
 * Description of TestingController
 *
 * @author Administrator
 */
class TestingController extends \BaseController {

    public function group() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data = array(
            'title' => 'ภาพรวมฝ่ายเทคโนโลยีสารเทศ',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'รายการทดสอบภาคปฏิบัติการใช้งานโปรแกรมคอมพิวเตอร์' => '#'
            )
        );
        if ($check->is('administrator')) {
            return \View::make('mod_mis.admin.index', $data);
        } elseif ($check->is('admin')) {
            return \View::make('mod_mis.testing.mis.index', $data);
        } elseif ($check->is('mis')) {
            return \View::make('mod_mis.testing.mis.group', $data);
        } elseif ($check->is('hr')) {
            return \View::make('mod_mis.home.hr.index', $data);
        }
    }

    public function group_listall() {
        $testing_group = \TestingGroup::select(array('id', 'title', 'desc', 'disabled'));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/testing/group/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/testing/group/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($testing_group)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function group_add() {
        if (!\Request::isMethod('post')) {
            return \View::make('mod_mis.testing.mis.group_add');
        } else {
            $rules = array(
                'title' => 'required',
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $testing_group = new \TestingGroup();
                $testing_group->title = trim(\Input::get('title'));
                $testing_group->desc = trim(\Input::get('desc'));
                $testing_group->disabled = (\Input::has('disabled') ? 0 : 1);
                $testing_group->created_user = \Auth::user()->id;
                $testing_group->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function group_edit($param) {
        if (!\Request::isMethod('post')) {
            $data = array(
                'item' => \TestingGroup::find($param)
            );
            return \View::make('mod_mis.testing.mis.group_edit');
        } else {
            $rules = array(
                'title' => 'required',
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $testing_group = \TestingGroup::find($param);
                $testing_group->title = trim(\Input::get('title'));
                $testing_group->desc = trim(\Input::get('desc'));
                $testing_group->disabled = (\Input::has('disabled') ? 0 : 1);
                $testing_group->updated_user = \Auth::user()->id;
                $testing_group->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

}
