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
class FormOnlineController extends \BaseController {

    public function index() {
        $data = array(
            'title' => 'แบบฟอร์มขอลงทะเบียน-ยกเลิก',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'แบบฟอร์มขอลงทะเบียน-ยกเลิก' => '#'
            )
        );
        return \View::make('mod_mis.formonline.register_cancel.shared.index', $data);
    }

    public function listall() {
        $testing_group = \Supplier::select(array('id', 'title', 'address', 'phone', 'fax', 'remark', 'disabled'));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/supplier/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/supplier/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($testing_group)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            return \View::make('mod_mis.supplier.mis.add');
        } else {
            $rules = array(
                'title' => 'required',
                'phone' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $supplier = new \Supplier();
                $supplier->title = trim(\Input::get('title'));
                $supplier->address = trim(\Input::get('address'));
                $supplier->phone = trim(\Input::get('phone'));
                $supplier->fax = trim(\Input::get('fax'));
                $supplier->remark = trim(\Input::get('remark'));
                $supplier->disabled = (\Input::has('disabled') ? 0 : 1);
                $supplier->save();
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
                'item' => \Supplier::find($param)
            );
            return \View::make('mod_mis.supplier.mis.edit', $data);
        } else {
            $rules = array(
                'title' => 'required',
                'phone' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $supplier = \Supplier::find($param);
                $supplier->title = trim(\Input::get('title'));
                $supplier->address = trim(\Input::get('address'));
                $supplier->phone = trim(\Input::get('phone'));
                $supplier->fax = trim(\Input::get('fax'));
                $supplier->remark = trim(\Input::get('remark'));
                $supplier->disabled = (\Input::has('disabled') ? 0 : 1);
                $supplier->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function delete($param) {
        try {
            \Supplier::find($param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'mis/supplier'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
