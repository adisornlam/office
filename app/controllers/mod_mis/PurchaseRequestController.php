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
class PurchaseRequestController extends \BaseController {

    public function index() {
        $data = array(
            'title' => 'รายการขอซื้อ',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'รายการขอซื้อ' => '#'
            )
        );
        return \View::make('mod_mis.purchaserequest.mis.index', $data);
    }

    public function listall() {
        $testing_group = \DB::table('purchase_request_item')
                ->join('company', 'purchase_request_item.company_id', '=', 'company.id')
                ->select(array('purchase_request_item.id as id', 'purchase_request_item.codes as codes', 'purchase_request_item.title as title', 'company.title as company', 'purchase_request_item.status as status', 'purchase_request_item.remark as remark', 'purchase_request_item.disabled as disabled', 'purchase_request_item.created_at as created_at'));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/purchaserequest/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/purchaserequest/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($testing_group)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function tmp_add() {
        var_dump(\Input::get());
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            $data = array(
                'title' => 'เพิ่มรายการขอซื้อ',
                'breadcrumbs' => array(
                    'ภาพรวมระบบ' => '',
                    'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                    'เพิ่มรายการขอซื้อ' => '#'
                ),
                'company' => \Company::lists('title', 'id'),
            );
            return \View::make('mod_mis.purchaserequest.mis.add', $data);
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
                $purchaserequest = new \Supplier();
                $purchaserequest->title = trim(\Input::get('title'));
                $purchaserequest->address = trim(\Input::get('address'));
                $purchaserequest->phone = trim(\Input::get('phone'));
                $purchaserequest->fax = trim(\Input::get('fax'));
                $purchaserequest->remark = trim(\Input::get('remark'));
                $purchaserequest->disabled = (\Input::has('disabled') ? 0 : 1);
                $purchaserequest->save();
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
            return \View::make('mod_mis.purchaserequest.mis.edit', $data);
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
                $purchaserequest = \Supplier::find($param);
                $purchaserequest->title = trim(\Input::get('title'));
                $purchaserequest->address = trim(\Input::get('address'));
                $purchaserequest->phone = trim(\Input::get('phone'));
                $purchaserequest->fax = trim(\Input::get('fax'));
                $purchaserequest->remark = trim(\Input::get('remark'));
                $purchaserequest->disabled = (\Input::has('disabled') ? 0 : 1);
                $purchaserequest->save();
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
                            'redirect' => 'mis/purchaserequest'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
