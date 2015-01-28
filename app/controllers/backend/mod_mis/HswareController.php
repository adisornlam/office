<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com
 */

namespace App\Controllers\Backend;

/**
 * Description of HswareController
 *
 * @author ComputerController
 */
class HswareController extends \BaseController {

    public function index() {
        $data = array(
            'title' => 'รายการอุปกรณ์',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => 'backend',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis/backend',
                'ระเบียนคอมพิวเตอร์' => 'mis/backend/computer',
                'รายการอุปกรณ์' => '#'
            )
        );
        return \View::make('backend.mod_mis.hsware.admin.index', $data);
    }

    public function group() {
        $data = array(
            'title' => 'รายการกลุ่มอุปกรณ์',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => 'backend',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis/backend',
                'ระเบียนคอมพิวเตอร์' => 'mis/backend/computer',
                'รายการอุปกรณ์' => 'mis/backend/hsware',
                'รายการกลุ่มอุปกรณ์' => '#'
            )
        );
        return \View::make('backend.mod_mis.hsware.admin.group', $data);
    }

    public function group_listall() {
        $hsware_group = \HswareGroup::select(array('id', 'title', 'limit_stock', 'remark', 'disabled'));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/backend/hsware/group/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/backend/hsware/group/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($hsware_group)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function group_add() {
        if (!\Request::isMethod('post')) {
            return \View::make('backend.mod_mis.hsware.admin.group_add');
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
                $hsware_group = new \HswareGroup();
                $hsware_group->title = trim(\Input::get('title'));
                $hsware_group->limit_stock = trim(\Input::get('limit_stock'));
                $hsware_group->remark = trim(\Input::get('remark'));
                $hsware_group->disabled = (\Input::has('disabled') ? 0 : 1);
                $hsware_group->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function group_edit($id = 0) {
        if (!\Request::isMethod('post')) {
            $data = array(
                'item' => \HswareGroup::find($id)
            );
            return \View::make('backend.mod_mis.hsware.admin.group_edit', $data);
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
                $hsware_group = \HswareGroup::find($id);
                $hsware_group->title = trim(\Input::get('title'));
                $hsware_group->limit_stock = trim(\Input::get('limit_stock'));
                $hsware_group->remark = trim(\Input::get('remark'));
                $hsware_group->disabled = (\Input::has('disabled') ? 0 : 1);
                $hsware_group->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function group_delete($param) {
        try {
            \HswareGroup::find($param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'mis/backend/hsware/group'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
