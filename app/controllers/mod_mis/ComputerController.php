<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com
 */

namespace App\Controllers;

/**
 * Description of MisController
 *
 * @author ComputerController
 */
class ComputerController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('auth', array('except' => '/login'));
    }

    public function index() {
        $serial_code22 = \HswareItem::get_gencode(1, 22);
        //echo $serial_code22;
        $data = array(
            'title' => 'ระเบียนคอมพิวเตอร์',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'ระเบียนคอมพิวเตอร์' => '#'
            ),
            'company' => \Company::lists('title', 'id')
        );

        return \View::make('mod_mis.computer.admin.index', $data);
    }

    public function listall() {
        $computer_item = \DB::table('computer_item')
                ->leftJoin('computer_user', 'computer_item.id', '=', 'computer_user.computer_id')
                ->leftJoin('users', 'users.id', '=', 'computer_user.user_id')
                ->leftJoin('department_item', 'users.department_id', '=', 'department_item.id')
                ->join('computer_type', 'computer_item.type_id', '=', 'computer_type.id')
                ->join('company', 'computer_item.company_id', '=', 'company.id')
                ->select(array(
            'computer_item.id as id',
            'computer_item.id as item_id',
            'computer_item.serial_code as serial_code',
            'computer_item.title as title',
            \DB::raw('CONCAT(users.codes," ",users.firstname," ",users.lastname," (",department_item.title,")") as fullname'),
            'computer_item.ip_address as ip_address',
            'company.title as company',
            'computer_item.disabled as disabled'
        ));

        if (\Input::has('company_id')) {
            $computer_item->where('computer_item.company_id', \Input::get('company_id'));
        }

        if (\Input::has('disabled')) {
            $computer_item->where('computer_item.disabled', \Input::get('disabled'));
        }

        if (\Input::has('type_id')) {
            $computer_item->where('computer_item.type_id', \Input::get('type_id'));
        }

        if (\Input::has('department_id')) {
            $computer_item->where('users.department_id', \Input::get('department_id'));
        }

        $computer_item->orderBy('computer_item.serial_code', 'ASC');

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="{{\URL::to("mis/computer/edit/$id")}}" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="{{\URL::to("mis/computer/export/$id")}}" title="พิมพ์ระเบียน" target="_blank"><i class="fa fa-print"></i> พิมพ์ระเบียน</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/computer/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($computer_item)
                        ->edit_column('id', $link)
                        ->edit_column('serial_code', function($result_obj) {
                            $str = '<a href="' . \URL::to('computer/view/' . $result_obj->item_id . '') . '" title="ดูรายละเอียด เลขระเบียน ' . $result_obj->serial_code . '">' . $result_obj->serial_code . '</a>';
                            return $str;
                        })
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function dialog() {
        $company = \Company::lists('title', 'id');
        $data = array(
            'company' => $company
        );
        return \View::make('mod_mis.computer.admin.dialog_add', $data);
    }

    public function dialog_notebook() {
        $company = \Company::lists('title', 'id');
        $data = array(
            'company' => $company
        );
        return \View::make('mod_mis.computer.admin.dialog_notebook_add', $data);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            $data = array(
                'title' => 'เพิ่ม Computer',
                'breadcrumbs' => array(
                    'ภาพรวมระบบ' => '',
                    'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                    'ระเบียนคอมพิวเตอร์' => 'mis/computer',
                    'เพิ่ม Computer' => '#'
                ),
                'company' => \Company::lists('title', 'id'),
                'place' => \Place::lists('title', 'id')
            );
            return \View::make('mod_mis.computer.admin.add_pc_wizard', $data);
        } else {
            $rules = array(
                'company_id' => 'required',
                'title' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {

                $computer_item = new \ComputerItem();
                $computer_item->company_id = \Input::get('company_id');
                $computer_item->type_id = \Input::get('type_id');
                $computer_item->serial_code = trim(\Input::get('serial_code'));
                $computer_item->access_no = trim(\Input::get('access_no'));
                $computer_item->title = trim(\Input::get('title'));
                $computer_item->ip_address = trim(\Input::get('ip_address'));
                $computer_item->mac_lan = trim(\Input::get('mac_lan'));
                $computer_item->mac_wireless = trim(\Input::get('mac_wireless'));
                $computer_item->locations = \Input::get('locations');
                $computer_item->register_date = trim(\Input::get('register_date'));
                $computer_item->disabled = (\Input::has('disabled') ? 0 : 1);
                $computer_item->created_user = \Auth::user()->id;
                $computer_item->save();
                $computer_id = $computer_item->id;
                if (\Input::has('user_item')) {
                    $computer_item->users()->sync(\Input::get('user_item'));
                    foreach (\Input::get('user_item') as $uitem) {
                        $hsware_item = \User::find($uitem);
                        $hsware_item->computer_status = 1;
                        $hsware_item->save();
                    }
                }
                if (\Input::get('hsware_item') > 0) {
                    $computer_item->hsware()->sync(\Input::get('hsware_item'));
                    foreach (\Input::get('hsware_item') as $item) {
                        $hsware_item = \HswareItem::find($item);
                        $hsware_item->status = 1;
                        $hsware_item->save();

                        $hslog = new \HswareComputerLog();
                        $hslog->hsware_id = $item;
                        $hslog->computer_id = $computer_id;
                        $hslog->created_user = \Auth::user()->id;
                        $hslog->save();
                    }
                }
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function add_wizard() {
        if (!\Request::isMethod('post')) {
            $data = array(
                'title' => 'เพิ่ม Computer',
                'breadcrumbs' => array(
                    'ภาพรวมระบบ' => '',
                    'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                    'ระเบียนคอมพิวเตอร์' => 'mis/computer',
                    'เพิ่ม Computer' => '#'
                ),
                'company' => \Company::lists('title', 'id'),
                'place' => \Place::lists('title', 'id')
            );

            return \View::make('mod_mis.computer.admin.add_pc_wizard', $data);
        } else {
            $rules = array(
                'company_id' => 'required',
                'title' => 'required|unique:computer_item'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $model = \Input::get('model_id');
                $sub_model = \Input::get('sub_model');
                $warranty_date = \Input::get('warranty_date');
                $spec_value_1 = \Input::get('spec_value_1');
                $spec_value_2 = \Input::get('spec_value_2');
                $spec_value_3 = \Input::get('spec_value_3');
                $spec_value_4 = \Input::get('spec_value_4');
                $spec_value_5 = \Input::get('spec_value_5');
                $spec_value_11 = \Input::get('spec_value_11');
                $spec_value_12 = \Input::get('spec_value_12');
                $spec_value_13 = \Input::get('spec_value_13');
                $spec_value_18 = \Input::get('spec_value_18');
                $spec_value_19 = \Input::get('spec_value_19');
                $spec_value_20 = \Input::get('spec_value_20');
                $spec_value_28 = \Input::get('spec_value_28');
                $spec_value_29 = \Input::get('spec_value_29');

                $computer_item = new \ComputerItem();
                $computer_item->company_id = \Input::get('company_id');
                $computer_item->software_group_id = (\Input::has('software_group_id') ? \Input::get('software_group_id') : 0);
                $computer_item->type_id = 1;
                $computer_item->serial_code = trim(\Input::get('serial_code'));
                $computer_item->access_no = trim(\Input::get('access_no'));
                $computer_item->title = trim(\Input::get('title'));
                $computer_item->ip_address = trim(\Input::get('ip_address'));
                $computer_item->mac_lan = trim(\Input::get('mac_lan'));
                $computer_item->mac_wireless = trim(\Input::get('mac_wireless'));
                $computer_item->locations = \Input::get('locations');
                $computer_item->floor = \Input::get('floor');
                $computer_item->register_date = trim(\Input::get('register_date'));
                $computer_item->disabled = (\Input::has('disabled') ? 0 : 1);
                $computer_item->created_user = \Auth::user()->id;
                $computer_item->save();
                $computer_id = $computer_item->id;

                if (\Input::has('user_item')) {
                    $computer_item->users()->sync(\Input::get('user_item'));
                    foreach (\Input::get('user_item') as $uitem) {
                        $hsware_item = \User::find($uitem);
                        $hsware_item->computer_status = 1;
                        $hsware_item->save();
                    }

                    $computer_user_log = new \ComputerUserLog();
                    $computer_user_log->computer_id = $computer_id;
                    $computer_user_log->user_id = $uitem;
                    $computer_user_log->created_user = \Auth::user()->id;
                    $computer_user_log->save();
                }

                if ($model[2][0] > 0) {
                    $serial_code2 = \HswareItem::get_gencode(\Input::get('company_id'), 2);
                    $hsware_item2 = new \HswareItem();
                    $hsware_item2->group_id = 2;
                    $hsware_item2->company_id = \Input::get('company_id');
                    $hsware_item2->serial_code = $serial_code2;
                    $hsware_item2->model_id = (isset($model[2][0]) ? $model[2][0] : 0);
                    $hsware_item2->sub_model = (isset($sub_model[2][0]) ? $sub_model[2][0] : 0);
                    $hsware_item2->spec_value_1 = (isset($spec_value_1[2][0]) ? $spec_value_1[2][0] : NULL);
                    $hsware_item2->spec_value_2 = (isset($spec_value_2[2][0]) ? $spec_value_2[2][0] : NULL);
                    $hsware_item2->spec_value_3 = (isset($spec_value_3[2][0]) ? $spec_value_3[2][0] : NULL);
                    $hsware_item2->spec_value_28 = (isset($spec_value_28[2][0]) ? $spec_value_28[2][0] : NULL);
                    $hsware_item2->locations = trim(\Input::get('locations'));
                    $hsware_item2->register_date = trim(\Input::get('register_date'));
                    $hsware_item2->warranty_date = (isset($warranty_date[2][0]) != '' ? trim($warranty_date[2][0]) : NULL);
                    $hsware_item2->status = 1;
                    $hsware_item2->spare = 0;
                    $hsware_item2->disabled = 0;
                    $hsware_item2->created_user = \Auth::user()->id;
                    $hsware_item2->save();
                    $hsware_id2 = $hsware_item2->id;
                    $hs_com2 = new \ComputerHsware();
                    $hs_com2->computer_id = $computer_id;
                    $hs_com2->hsware_id = $hsware_id2;
                    $hs_com2->save();
                    $hslog2 = new \HswareComputerLog();
                    $hslog2->hsware_id = $hsware_id2;
                    $hslog2->computer_id = $computer_id;
                    $hslog2->created_user = \Auth::user()->id;
                    $hslog2->save();
                }

                if ($model[8][0] > 0) {
                    $serial_code8 = \HswareItem::get_gencode(\Input::get('company_id'), 8);
                    $hsware_item8 = new \HswareItem();
                    $hsware_item8->group_id = 8;
                    $hsware_item8->company_id = \Input::get('company_id');
                    $hsware_item8->serial_code = $serial_code8;
                    $hsware_item8->model_id = (isset($model[8][0]) ? $model[8][0] : 0);
                    $hsware_item8->sub_model = (isset($sub_model[8][0]) ? $sub_model[8][0] : 0);
                    $hsware_item8->spec_value_12 = (isset($spec_value_12[8][0]) ? $spec_value_12[8][0] : NULL);
                    $hsware_item8->spec_value_13 = (isset($spec_value_13[8][0]) ? $spec_value_13[8][0] : NULL);
                    $hsware_item8->spec_value_29 = (isset($spec_value_29[8][0]) ? $spec_value_29[8][0] : NULL);
                    $hsware_item8->locations = trim(\Input::get('locations'));
                    $hsware_item8->register_date = trim(\Input::get('register_date'));
                    $hsware_item8->warranty_date = (isset($warranty_date[8][0]) != '' ? trim($warranty_date[8][0]) : NULL);
                    $hsware_item8->status = 1;
                    $hsware_item8->spare = 0;
                    $hsware_item8->disabled = 0;
                    $hsware_item8->created_user = \Auth::user()->id;
                    $hsware_item8->save();
                    $hsware_id8 = $hsware_item8->id;
                    $hs_com8 = new \ComputerHsware();
                    $hs_com8->computer_id = $computer_id;
                    $hs_com8->hsware_id = $hsware_id8;
                    $hs_com8->save();
                    $hslog8 = new \HswareComputerLog();
                    $hslog8->hsware_id = $hsware_id8;
                    $hslog8->computer_id = $computer_id;
                    $hslog8->created_user = \Auth::user()->id;
                    $hslog8->save();
                }

                if ($model[22][0] > 0) {
                    $serial_code22 = \HswareItem::get_gencode(\Input::get('company_id'), 22);
                    $hsware_item22 = new \HswareItem();
                    $hsware_item22->group_id = 22;
                    $hsware_item22->company_id = \Input::get('company_id');
                    $hsware_item22->serial_code = $serial_code22;
                    $hsware_item22->model_id = (isset($model[22][0]) ? $model[22][0] : 0);
                    $hsware_item22->spec_value_4 = (isset($spec_value_4[22][0]) ? $spec_value_4[22][0] : NULL);
                    $hsware_item22->locations = trim(\Input::get('locations'));
                    $hsware_item22->register_date = trim(\Input::get('register_date'));
                    $hsware_item22->warranty_date = (isset($warranty_date[22][0]) != '' ? trim($warranty_date[22][0]) : NULL);
                    $hsware_item22->status = 1;
                    $hsware_item22->spare = 0;
                    $hsware_item22->disabled = 0;
                    $hsware_item22->created_user = \Auth::user()->id;
                    $hsware_item22->save();
                    $hsware_id22 = $hsware_item22->id;
                    $hs_com22 = new \ComputerHsware();
                    $hs_com22->computer_id = $computer_id;
                    $hs_com22->hsware_id = $hsware_id22;
                    $hs_com22->save();
                    $hslog22 = new \HswareComputerLog();
                    $hslog22->hsware_id = $hsware_id22;
                    $hslog22->computer_id = $computer_id;
                    $hslog22->created_user = \Auth::user()->id;
                    $hslog22->save();
                }

                if ($model[22][1] > 0) {
                    $serial_code222 = \HswareItem::get_gencode(\Input::get('company_id'), 22);
                    $hsware_item222 = new \HswareItem();
                    $hsware_item222->group_id = 22;
                    $hsware_item222->company_id = \Input::get('company_id');
                    $hsware_item222->serial_code = $serial_code222;
                    $hsware_item222->model_id = (isset($model[22][1]) ? $model[22][1] : 0);
                    $hsware_item222->spec_value_4 = (isset($spec_value_4[22][1]) ? $spec_value_4[22][1] : NULL);
                    $hsware_item222->locations = trim(\Input::get('locations'));
                    $hsware_item222->register_date = trim(\Input::get('register_date'));
                    $hsware_item222->warranty_date = (isset($warranty_date[22][1]) != '' ? trim($warranty_date[22][1]) : NULL);
                    $hsware_item222->status = 1;
                    $hsware_item222->spare = 0;
                    $hsware_item222->disabled = 0;
                    $hsware_item222->created_user = \Auth::user()->id;
                    $hsware_item222->save();
                    $hsware_id222 = $hsware_item222->id;
                    $hs_com222 = new \ComputerHsware();
                    $hs_com222->computer_id = $computer_id;
                    $hs_com222->hsware_id = $hsware_id222;
                    $hs_com222->save();
                    $hslog222 = new \HswareComputerLog();
                    $hslog222->hsware_id = $hsware_id222;
                    $hslog222->computer_id = $computer_id;
                    $hslog222->created_user = \Auth::user()->id;
                    $hslog222->save();
                }

                if ($model[3][0] > 0) {
                    $serial_code3 = \HswareItem::get_gencode(\Input::get('company_id'), 3);
                    $hsware_item3 = new \HswareItem();
                    $hsware_item3->group_id = 3;
                    $hsware_item3->company_id = \Input::get('company_id');
                    $hsware_item3->serial_code = $serial_code3;
                    $hsware_item3->model_id = (isset($model[3][0]) ? $model[3][0] : 0);
                    $hsware_item3->spec_value_2 = (isset($spec_value_2[3][0]) ? $spec_value_2[3][0] : NULL);
                    $hsware_item3->spec_value_4 = (isset($spec_value_4[3][0]) ? $spec_value_4[3][0] : NULL);
                    $hsware_item3->spec_value_5 = (isset($spec_value_5[3][0]) ? $spec_value_5[3][0] : NULL);
                    $hsware_item3->locations = trim(\Input::get('locations'));
                    $hsware_item3->register_date = trim(\Input::get('register_date'));
                    $hsware_item3->warranty_date = (isset($warranty_date[3][0]) != '' ? trim($warranty_date[3][0]) : NULL);
                    $hsware_item3->status = 1;
                    $hsware_item3->spare = 0;
                    $hsware_item3->disabled = 0;
                    $hsware_item3->created_user = \Auth::user()->id;
                    $hsware_item3->save();
                    $hsware_id3 = $hsware_item3->id;
                    $hs_com3 = new \ComputerHsware();
                    $hs_com3->computer_id = $computer_id;
                    $hs_com3->hsware_id = $hsware_id3;
                    $hs_com3->save();
                    $hslog3 = new \HswareComputerLog();
                    $hslog3->hsware_id = $hsware_id3;
                    $hslog3->computer_id = $computer_id;
                    $hslog3->created_user = \Auth::user()->id;
                    $hslog3->save();
                }

                if ($model[3][1] > 0) {
                    $serial_code31 = \HswareItem::get_gencode(\Input::get('company_id'), 3);
                    $hsware_item31 = new \HswareItem();
                    $hsware_item31->group_id = 3;
                    $hsware_item31->company_id = \Input::get('company_id');
                    $hsware_item31->serial_code = $serial_code31;
                    $hsware_item31->model_id = (isset($model[3][1]) ? $model[3][1] : 0);
                    $hsware_item31->spec_value_2 = (isset($spec_value_2[3][1]) ? $spec_value_2[3][1] : NULL);
                    $hsware_item31->spec_value_4 = (isset($spec_value_4[3][1]) ? $spec_value_4[3][1] : NULL);
                    $hsware_item31->spec_value_5 = (isset($spec_value_5[3][1]) ? $spec_value_5[3][1] : NULL);
                    $hsware_item31->locations = trim(\Input::get('locations'));
                    $hsware_item31->register_date = trim(\Input::get('register_date'));
                    $hsware_item31->warranty_date = (isset($warranty_date[3][0]) != '' ? trim($warranty_date[3][0]) : NULL);
                    $hsware_item31->status = 1;
                    $hsware_item31->spare = 0;
                    $hsware_item31->disabled = 0;
                    $hsware_item31->created_user = \Auth::user()->id;
                    $hsware_item31->save();
                    $hsware_id31 = $hsware_item31->id;
                    $hs_com31 = new \ComputerHsware();
                    $hs_com31->computer_id = $computer_id;
                    $hs_com31->hsware_id = $hsware_id31;
                    $hs_com31->save();
                    $hslog31 = new \HswareComputerLog();
                    $hslog31->hsware_id = $hsware_id31;
                    $hslog31->computer_id = $computer_id;
                    $hslog31->created_user = \Auth::user()->id;
                    $hslog31->save();
                }

                if ($model[6][0] > 0) {
                    $serial_code6 = \HswareItem::get_gencode(\Input::get('company_id'), 6);
                    $hsware_item6 = new \HswareItem();
                    $hsware_item6->group_id = 6;
                    $hsware_item6->company_id = \Input::get('company_id');
                    $hsware_item6->serial_code = $serial_code6;
                    $hsware_item6->model_id = (isset($model[6][0]) ? $model[6][0] : 0);
                    $hsware_item6->locations = trim(\Input::get('locations'));
                    $hsware_item6->register_date = trim(\Input::get('register_date'));
                    $hsware_item6->warranty_date = (isset($warranty_date[6][0]) != '' ? trim($warranty_date[6][0]) : NULL);
                    $hsware_item6->status = 1;
                    $hsware_item6->spare = 0;
                    $hsware_item6->disabled = 0;
                    $hsware_item6->created_user = \Auth::user()->id;
                    $hsware_item6->save();
                    $hsware_id6 = $hsware_item6->id;
                    $hs_com6 = new \ComputerHsware();
                    $hs_com6->computer_id = $computer_id;
                    $hs_com6->hsware_id = $hsware_id6;
                    $hs_com6->save();
                    $hslog6 = new \HswareComputerLog();
                    $hslog6->hsware_id = $hsware_id6;
                    $hslog6->computer_id = $computer_id;
                    $hslog6->created_user = \Auth::user()->id;
                    $hslog6->save();
                }

                if ($model[5][0] > 0) {
                    $serial_code5 = \HswareItem::get_gencode(\Input::get('company_id'), 5);
                    $hsware_item5 = new \HswareItem();
                    $hsware_item5->group_id = 5;
                    $hsware_item5->company_id = \Input::get('company_id');
                    $hsware_item5->serial_code = $serial_code5;
                    $hsware_item5->model_id = (isset($model[5][0]) ? $model[5][0] : 0);
                    $hsware_item5->locations = trim(\Input::get('locations'));
                    $hsware_item5->register_date = trim(\Input::get('register_date'));
                    $hsware_item5->warranty_date = (isset($warranty_date[5][0]) != '' ? trim($warranty_date[5][0]) : NULL);
                    $hsware_item5->status = 1;
                    $hsware_item5->spare = 0;
                    $hsware_item5->disabled = 0;
                    $hsware_item5->created_user = \Auth::user()->id;
                    $hsware_item5->save();
                    $hsware_id5 = $hsware_item5->id;
                    $hs_com5 = new \ComputerHsware();
                    $hs_com5->computer_id = $computer_id;
                    $hs_com5->hsware_id = $hsware_id5;
                    $hs_com5->save();
                    $hslog5 = new \HswareComputerLog();
                    $hslog5->hsware_id = $hsware_id5;
                    $hslog5->computer_id = $computer_id;
                    $hslog5->created_user = \Auth::user()->id;
                    $hslog5->save();
                }

                if ($model[7][0] > 0) {
                    $serial_code7 = \HswareItem::get_gencode(\Input::get('company_id'), 7);
                    $hsware_item7 = new \HswareItem();
                    $hsware_item7->group_id = 7;
                    $hsware_item7->company_id = \Input::get('company_id');
                    $hsware_item7->serial_code = $serial_code7;
                    $hsware_item7->model_id = (isset($model[7][0]) ? $model[7][0] : 0);
                    $hsware_item31->spec_value_11 = (isset($spec_value_11[7][0]) ? $spec_value_11[7][0] : NULL);
                    $hsware_item7->locations = trim(\Input::get('locations'));
                    $hsware_item7->register_date = trim(\Input::get('register_date'));
                    $hsware_item7->warranty_date = (isset($warranty_date[7][0]) != '' ? trim($warranty_date[7][0]) : NULL);
                    $hsware_item7->status = 1;
                    $hsware_item7->spare = 0;
                    $hsware_item7->disabled = 0;
                    $hsware_item7->created_user = \Auth::user()->id;
                    $hsware_item7->save();
                    $hsware_id7 = $hsware_item7->id;
                    $hs_com7 = new \ComputerHsware();
                    $hs_com7->computer_id = $computer_id;
                    $hs_com7->hsware_id = $hsware_id7;
                    $hs_com7->save();
                    $hslog7 = new \HswareComputerLog();
                    $hslog7->hsware_id = $hsware_id7;
                    $hslog7->computer_id = $computer_id;
                    $hslog7->created_user = \Auth::user()->id;
                    $hslog7->save();
                }

                if ($model[26][0] > 0) {
                    $serial_code26 = \HswareItem::get_gencode(\Input::get('company_id'), 26);
                    $hsware_item26 = new \HswareItem();
                    $hsware_item26->group_id = 26;
                    $hsware_item26->company_id = \Input::get('company_id');
                    $hsware_item26->serial_code = $serial_code26;
                    $hsware_item26->model_id = (isset($model[26][0]) ? $model[26][0] : 0);
                    $hsware_item26->locations = trim(\Input::get('locations'));
                    $hsware_item26->register_date = trim(\Input::get('register_date'));
                    $hsware_item26->warranty_date = (isset($warranty_date[26][0]) != '' ? trim($warranty_date[26][0]) : NULL);
                    $hsware_item26->status = 1;
                    $hsware_item26->spare = 0;
                    $hsware_item26->disabled = 0;
                    $hsware_item26->created_user = \Auth::user()->id;
                    $hsware_item26->save();
                    $hsware_id26 = $hsware_item26->id;
                    $hs_com26 = new \ComputerHsware();
                    $hs_com26->computer_id = $computer_id;
                    $hs_com26->hsware_id = $hsware_id26;
                    $hs_com26->save();
                    $hslog26 = new \HswareComputerLog();
                    $hslog26->hsware_id = $hsware_id26;
                    $hslog26->computer_id = $computer_id;
                    $hslog26->created_user = \Auth::user()->id;
                    $hslog26->save();
                }

                if ($model[14][0] > 0) {
                    $serial_code14 = \HswareItem::get_gencode(\Input::get('company_id'), 14);
                    $hsware_item14 = new \HswareItem();
                    $hsware_item14->group_id = 14;
                    $hsware_item14->company_id = \Input::get('company_id');
                    $hsware_item14->serial_code = $serial_code14;
                    $hsware_item14->model_id = (isset($model[14][0]) ? $model[14][0] : 0);
                    $hsware_item14->sub_model = (isset($sub_model[14][0]) ? $sub_model[14][0] : 0);
                    $hsware_item14->spec_value_19 = (isset($spec_value_19[14][0]) ? $spec_value_19[14][0] : NULL);
                    $hsware_item14->spec_value_20 = (isset($spec_value_20[14][0]) ? $spec_value_20[14][0] : NULL);
                    $hsware_item14->locations = trim(\Input::get('locations'));
                    $hsware_item14->register_date = trim(\Input::get('register_date'));
                    $hsware_item14->warranty_date = (isset($warranty_date[14][0]) != '' ? trim($warranty_date[14][0]) : NULL);
                    $hsware_item14->status = 1;
                    $hsware_item14->spare = 0;
                    $hsware_item14->disabled = 0;
                    $hsware_item14->created_user = \Auth::user()->id;
                    $hsware_item14->save();
                    $hsware_id14 = $hsware_item14->id;
                    $hs_com14 = new \ComputerHsware();
                    $hs_com14->computer_id = $computer_id;
                    $hs_com14->hsware_id = $hsware_id14;
                    $hs_com14->save();
                    $hslog14 = new \HswareComputerLog();
                    $hslog14->hsware_id = $hsware_id14;
                    $hslog14->computer_id = $computer_id;
                    $hslog14->created_user = \Auth::user()->id;
                    $hslog14->save();
                }

                if ($model[13][0] > 0) {
                    $serial_code13 = \HswareItem::get_gencode(\Input::get('company_id'), 13);
                    $hsware_item13 = new \HswareItem();
                    $hsware_item13->group_id = 13;
                    $hsware_item13->company_id = \Input::get('company_id');
                    $hsware_item13->serial_code = $serial_code13;
                    $hsware_item13->model_id = (isset($model[13][0]) ? $model[13][0] : 0);
                    $hsware_item13->spec_value_18 = (isset($spec_value_18[13][0]) ? $spec_value_18[13][0] : NULL);
                    $hsware_item13->locations = trim(\Input::get('locations'));
                    $hsware_item13->register_date = trim(\Input::get('register_date'));
                    $hsware_item13->warranty_date = (isset($warranty_date[13][0]) != '' ? trim($warranty_date[13][0]) : NULL);
                    $hsware_item13->status = 1;
                    $hsware_item13->spare = 0;
                    $hsware_item13->disabled = 0;
                    $hsware_item13->created_user = \Auth::user()->id;
                    $hsware_item13->save();
                    $hsware_id13 = $hsware_item13->id;
                    $hs_com13 = new \ComputerHsware();
                    $hs_com13->computer_id = $computer_id;
                    $hs_com13->hsware_id = $hsware_id13;
                    $hs_com13->save();
                    $hslog13 = new \HswareComputerLog();
                    $hslog13->hsware_id = $hsware_id13;
                    $hslog13->computer_id = $computer_id;
                    $hslog13->created_user = \Auth::user()->id;
                    $hslog13->save();
                }

                if (\Input::get('software_group_id') > 0) {

                    $software_arr = \DB::table('software_group_item')
                            ->join('software_group', 'software_group_item.id', '=', 'software_group.group_id')
                            ->join('software_item', 'software_group.software_id', '=', 'software_item.id')
                            ->where('software_group_item.id', \Input::get('software_group_id'))
                            ->where('software_group_item.disabled', 0)
                            ->select(array(
                                'software_item.id as id',
                            ))
                            ->lists('id');
                    $computer_item->software()->sync($software_arr);
                    foreach ($software_arr as $item) {
                        $hslog = new \ComputerSoftwareLog();
                        $hslog->computer_id = $computer_id;
                        $hslog->software_id = $item;
                        $hslog->created_user = \Auth::user()->id;
                        $hslog->save();
                    }
                }

                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function add_notebook_wizard() {
        if (!\Request::isMethod('post')) {
            $data = array(
                'title' => 'เพิ่ม Notebook',
                'breadcrumbs' => array(
                    'ภาพรวมระบบ' => '',
                    'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                    'ระเบียนคอมพิวเตอร์' => 'mis/computer',
                    'เพิ่ม Notebook' => '#'
                ),
                'company' => \Company::lists('title', 'id'),
                'place' => \Place::lists('title', 'id')
            );

            return \View::make('mod_mis.computer.admin.add_notebook_wizard', $data);
        } else {
            $rules = array(
                'company_id' => 'required',
                'title' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $model = \Input::get('model_id'); //1 2 3 12 13 29 4 35 2 5 28
                $sub_model = \Input::get('sub_model');
                $warranty_date = \Input::get('warranty_date');
                $spec_value_2 = \Input::get('spec_value_2');
                $spec_value_4 = \Input::get('spec_value_4');
                $spec_value_5 = \Input::get('spec_value_5');
                $spec_value_12 = \Input::get('spec_value_12');
                $spec_value_13 = \Input::get('spec_value_13');
                $spec_value_29 = \Input::get('spec_value_29');

                $computer_item = new \ComputerItem();
                $computer_item->company_id = \Input::get('company_id');
                $computer_item->type_id = 2;
                $computer_item->software_group_id = (\Input::has('software_group_id') ? \Input::get('software_group_id') : 0);
                $computer_item->nb_model = (isset($model[27][0]) ? $model[27][0] : 0);
                $computer_item->nb_submodel = (isset($sub_model[27][0]) ? $sub_model[27][0] : 0);
                $computer_item->serial_code = trim(\Input::get('serial_code'));
                $computer_item->access_no = trim(\Input::get('access_no'));
                $computer_item->title = trim(\Input::get('title'));
                $computer_item->ip_address = trim(\Input::get('ip_address'));
                $computer_item->mac_lan = trim(\Input::get('mac_lan'));
                $computer_item->mac_wireless = trim(\Input::get('mac_wireless'));
                $computer_item->locations = \Input::get('locations');
                $computer_item->register_date = trim(\Input::get('register_date'));
                $computer_item->warranty_date = (isset($warranty_date) != '' ? trim($warranty_date) : NULL);
                $computer_item->disabled = (\Input::has('disabled') ? 0 : 1);
                $computer_item->created_user = \Auth::user()->id;
                $computer_item->save();
                $computer_id = $computer_item->id;

                if (\Input::has('user_item')) {
                    $computer_item->users()->sync(\Input::get('user_item'));
                    foreach (\Input::get('user_item') as $uitem) {
                        $hsware_item = \User::find($uitem);
                        $hsware_item->notebook_status = 1;
                        $hsware_item->save();

                        $computer_user_log = new \ComputerUserLog();
                        $computer_user_log->computer_id = $computer_id;
                        $computer_user_log->user_id = $uitem;
                        $computer_user_log->created_user = \Auth::user()->id;
                        $computer_user_log->save();
                    }
                }

                if ($model[8][0] > 0) {
                    $serial_code8 = \HswareItem::get_gencode(\Input::get('company_id'), 8);
                    $hsware_item8 = new \HswareItem();
                    $hsware_item8->group_id = 8;
                    $hsware_item8->type_id = 2;
                    $hsware_item8->company_id = \Input::get('company_id');
                    $hsware_item8->serial_code = $serial_code8;
                    $hsware_item8->model_id = (isset($model[8][0]) ? $model[8][0] : 0);
                    $hsware_item8->sub_model = (isset($sub_model[8][0]) ? $sub_model[8][0] : 0);
                    $hsware_item8->spec_value_12 = (isset($spec_value_12[8][0]) ? $spec_value_12[8][0] : NULL);
                    $hsware_item8->spec_value_13 = (isset($spec_value_13[8][0]) ? $spec_value_13[8][0] : NULL);
                    $hsware_item8->spec_value_29 = (isset($spec_value_29[8][0]) ? $spec_value_29[8][0] : NULL);
                    $hsware_item8->locations = trim(\Input::get('locations'));
                    $hsware_item8->register_date = trim(\Input::get('register_date'));
                    $hsware_item8->warranty_date = (isset($warranty_date) != '' ? trim($warranty_date) : NULL);
                    $hsware_item8->status = 1;
                    $hsware_item8->spare = 0;
                    $hsware_item8->disabled = 0;
                    $hsware_item8->created_user = \Auth::user()->id;
                    $hsware_item8->save();
                    $hsware_id8 = $hsware_item8->id;
                    $hs_com8 = new \ComputerHsware();
                    $hs_com8->computer_id = $computer_id;
                    $hs_com8->hsware_id = $hsware_id8;
                    $hs_com8->save();
                    $hslog8 = new \HswareComputerLog();
                    $hslog8->hsware_id = $hsware_id8;
                    $hslog8->computer_id = $computer_id;
                    $hslog8->created_user = \Auth::user()->id;
                    $hslog8->save();
                }

                if ($model[22][0] > 0) {
                    $serial_code22 = \HswareItem::get_gencode(\Input::get('company_id'), 22);
                    $hsware_item22 = new \HswareItem();
                    $hsware_item22->group_id = 22;
                    $hsware_item22->type_id = 2;
                    $hsware_item22->company_id = \Input::get('company_id');
                    $hsware_item22->serial_code = $serial_code22;
                    $hsware_item22->model_id = (isset($model[22][0]) ? $model[22][0] : 0);
                    $hsware_item22->spec_value_4 = (isset($spec_value_4[22][0]) ? $spec_value_4[22][0] : NULL);
                    $hsware_item22->locations = trim(\Input::get('locations'));
                    $hsware_item22->register_date = trim(\Input::get('register_date'));
                    $hsware_item22->warranty_date = (isset($warranty_date) != '' ? trim($warranty_date) : NULL);
                    $hsware_item22->status = 1;
                    $hsware_item22->spare = 0;
                    $hsware_item22->disabled = 0;
                    $hsware_item22->created_user = \Auth::user()->id;
                    $hsware_item22->save();
                    $hsware_id22 = $hsware_item22->id;
                    $hs_com22 = new \ComputerHsware();
                    $hs_com22->computer_id = $computer_id;
                    $hs_com22->hsware_id = $hsware_id22;
                    $hs_com22->save();
                    $hslog22 = new \HswareComputerLog();
                    $hslog22->hsware_id = $hsware_id22;
                    $hslog22->computer_id = $computer_id;
                    $hslog22->created_user = \Auth::user()->id;
                    $hslog22->save();
                }

                if ($model[22][1] > 0) {
                    $serial_code222 = \HswareItem::get_gencode(\Input::get('company_id'), 22);
                    $hsware_item222 = new \HswareItem();
                    $hsware_item222->group_id = 22;
                    $hsware_item222->type_id = 2;
                    $hsware_item222->company_id = \Input::get('company_id');
                    $hsware_item222->serial_code = $serial_code222;
                    $hsware_item222->model_id = (isset($model[22][1]) ? $model[22][1] : 0);
                    $hsware_item222->spec_value_4 = (isset($spec_value_4[22][1]) ? $spec_value_4[22][1] : NULL);
                    $hsware_item222->locations = trim(\Input::get('locations'));
                    $hsware_item222->register_date = trim(\Input::get('register_date'));
                    $hsware_item222->warranty_date = (isset($warranty_date) != '' ? trim($warranty_date) : NULL);
                    $hsware_item222->status = 1;
                    $hsware_item222->spare = 0;
                    $hsware_item222->disabled = 0;
                    $hsware_item222->created_user = \Auth::user()->id;
                    $hsware_item222->save();
                    $hsware_id222 = $hsware_item222->id;
                    $hs_com222 = new \ComputerHsware();
                    $hs_com222->computer_id = $computer_id;
                    $hs_com222->hsware_id = $hsware_id222;
                    $hs_com222->save();
                    $hslog222 = new \HswareComputerLog();
                    $hslog222->hsware_id = $hsware_id222;
                    $hslog222->computer_id = $computer_id;
                    $hslog222->created_user = \Auth::user()->id;
                    $hslog222->save();
                }

                if ($model[3][0] > 0) {
                    $serial_code3 = \HswareItem::get_gencode(\Input::get('company_id'), 3);
                    $hsware_item3 = new \HswareItem();
                    $hsware_item3->group_id = 3;
                    $hsware_item3->company_id = \Input::get('company_id');
                    $hsware_item3->serial_code = $serial_code3;
                    $hsware_item3->type_id = 2;
                    $hsware_item3->model_id = (isset($model[3][0]) ? $model[3][0] : 0);
                    $hsware_item3->spec_value_2 = (isset($spec_value_2[3][0]) ? $spec_value_2[3][0] : NULL);
                    $hsware_item3->spec_value_4 = (isset($spec_value_4[3][0]) ? $spec_value_4[3][0] : NULL);
                    $hsware_item3->spec_value_5 = (isset($spec_value_5[3][0]) ? $spec_value_5[3][0] : NULL);
                    $hsware_item3->locations = trim(\Input::get('locations'));
                    $hsware_item3->register_date = trim(\Input::get('register_date'));
                    $hsware_item3->warranty_date = (isset($warranty_date) != '' ? trim($warranty_date) : NULL);
                    $hsware_item3->status = 1;
                    $hsware_item3->spare = 0;
                    $hsware_item3->disabled = 0;
                    $hsware_item3->created_user = \Auth::user()->id;
                    $hsware_item3->save();
                    $hsware_id3 = $hsware_item3->id;
                    $hs_com3 = new \ComputerHsware();
                    $hs_com3->computer_id = $computer_id;
                    $hs_com3->hsware_id = $hsware_id3;
                    $hs_com3->save();
                    $hslog3 = new \HswareComputerLog();
                    $hslog3->hsware_id = $hsware_id3;
                    $hslog3->computer_id = $computer_id;
                    $hslog3->created_user = \Auth::user()->id;
                    $hslog3->save();
                }

                if ($model[3][1] > 0) {
                    $serial_code31 = \HswareItem::get_gencode(\Input::get('company_id'), 3);
                    $hsware_item31 = new \HswareItem();
                    $hsware_item31->group_id = 3;
                    $hsware_item31->company_id = \Input::get('company_id');
                    $hsware_item31->serial_code = $serial_code31;
                    $hsware_item31->type_id = 2;
                    $hsware_item31->model_id = (isset($model[3][1]) ? $model[3][1] : 0);
                    $hsware_item31->spec_value_2 = (isset($spec_value_2[3][1]) ? $spec_value_2[3][1] : NULL);
                    $hsware_item31->spec_value_4 = (isset($spec_value_4[3][1]) ? $spec_value_4[3][1] : NULL);
                    $hsware_item31->spec_value_5 = (isset($spec_value_5[3][1]) ? $spec_value_5[3][1] : NULL);
                    $hsware_item31->locations = trim(\Input::get('locations'));
                    $hsware_item31->register_date = trim(\Input::get('register_date'));
                    $hsware_item31->warranty_date = (isset($warranty_date) != '' ? trim($warranty_date) : NULL);
                    $hsware_item31->status = 1;
                    $hsware_item31->spare = 0;
                    $hsware_item31->disabled = 0;
                    $hsware_item31->created_user = \Auth::user()->id;
                    $hsware_item31->save();
                    $hsware_id31 = $hsware_item31->id;
                    $hs_com31 = new \ComputerHsware();
                    $hs_com31->computer_id = $computer_id;
                    $hs_com31->hsware_id = $hsware_id31;
                    $hs_com31->save();
                    $hslog31 = new \HswareComputerLog();
                    $hslog31->hsware_id = $hsware_id31;
                    $hslog31->computer_id = $computer_id;
                    $hslog31->created_user = \Auth::user()->id;
                    $hslog31->save();
                }

                if (\Input::get('software_group_id') > 0) {

                    $software_arr = \DB::table('software_group_item')
                            ->join('software_group', 'software_group_item.id', '=', 'software_group.group_id')
                            ->join('software_item', 'software_group.software_id', '=', 'software_item.id')
                            ->where('software_group_item.id', \Input::get('software_group_id'))
                            ->where('software_group_item.disabled', 0)
                            ->select(array(
                                'software_item.id as id',
                            ))
                            ->lists('id');
                    $computer_item->software()->sync($software_arr);
                    foreach ($software_arr as $item) {
                        $hslog = new \ComputerSoftwareLog();
                        $hslog->computer_id = $computer_id;
                        $hslog->software_id = $item;
                        $hslog->created_user = \Auth::user()->id;
                        $hslog->save();
                    }
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
            $item = \DB::table('computer_item')
                    ->leftJoin('computer_user', 'computer_item.id', '=', 'computer_user.computer_id')
                    ->leftJoin('users', 'users.id', '=', 'computer_user.user_id')
                    ->leftJoin('position_item', 'position_item.id', '=', 'users.position_id')
                    ->where('computer_item.id', $param)
                    ->select(array(
                        'computer_item.id as id',
                        'computer_item.title as title',
                        'computer_item.company_id as company_id',
                        'computer_item.software_group_id as software_group_id',
                        'computer_item.serial_code as serial_code',
                        'computer_item.access_no as access_no',
                        'computer_item.type_id as type_id',
                        'computer_item.locations as locations',
                        'computer_item.floor as floor',
                        'computer_item.ip_address as ip_address',
                        'computer_item.mac_lan as mac_lan',
                        'computer_item.mac_wireless as mac_wireless',
                        'computer_item.register_date as register_date',
                        'computer_item.disabled as disabled',
                        \DB::raw('CONCAT(users.firstname," ",users.lastname) as fullname'),
                        'position_item.title as position',
                        'users.id as user_id'
                    ))
                    ->first();
            $data = array(
                'title' => 'แก่ไข Computer ' . $item->title,
                'breadcrumbs' => array(
                    'ภาพรวมระบบ' => '',
                    'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                    'ระเบียนคอมพิวเตอร์' => 'mis/computer',
                    'แก่ไข Computer ' . $item->title => '#'
                ),
                'item' => $item,
                'company' => \Company::lists('title', 'id'),
                'place' => \Place::lists('title', 'id')
            );

            return \View::make('mod_mis.computer.admin.edit', $data);
        } else {
            $rules = array(
                'company_id' => 'required',
                'title' => 'required',
                'ip_address' => 'ip'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $computer_item = \ComputerItem::find($param);
                $computer_item->company_id = \Input::get('company_id');
                $computer_item->software_group_id = (\Input::has('software_group_id') ? \Input::get('software_group_id') : 0);
                $computer_item->type_id = \Input::get('type_id');
                $computer_item->serial_code = trim(\Input::get('serial_code'));
                $computer_item->access_no = trim(\Input::get('access_no'));
                $computer_item->ip_address = trim(\Input::get('ip_address'));
                $computer_item->title = trim(\Input::get('title'));
                $computer_item->ip_address = trim(\Input::get('ip_address'));
                $computer_item->mac_lan = trim(\Input::get('mac_lan'));
                $computer_item->mac_wireless = trim(\Input::get('mac_wireless'));
                $computer_item->locations = \Input::get('locations');
                $computer_item->floor = \Input::get('floor');
                $computer_item->register_date = trim(\Input::get('register_date'));
                $computer_item->disabled = (\Input::has('disabled') ? 0 : 1);
                $computer_item->updated_user = \Auth::user()->id;
                $computer_item->save();
                $computer_id = $computer_item->id;
                if (\Input::has('user_item')) {
                    \DB::table('users')
                            ->join('computer_user', 'users.id', '=', 'computer_user.user_id')
                            ->where('computer_user.computer_id', $param)
                            ->update(array('users.computer_status' => 0));
                    $computer_item->users()->sync(\Input::get('user_item'));
                    foreach (\Input::get('user_item') as $uitem) {
                        $hsware_item = \User::find($uitem);
                        $hsware_item->computer_status = 1;
                        $hsware_item->save();
                    }

                    $computer_user_log = new \ComputerUserLog();
                    $computer_user_log->computer_id = $computer_id;
                    $computer_user_log->user_id = $uitem;
                    $computer_user_log->created_user = \Auth::user()->id;
                    $computer_user_log->save();
                }
                if (\Input::get('hsware_item') > 0) {
                    \DB::table('hsware_item')
                            ->join('computer_hsware', 'hsware_item.id', '=', 'computer_hsware.hsware_id')
                            ->where('computer_hsware.computer_id', $param)
                            ->update(array('hsware_item.status' => 0));
                    $computer_item->hsware()->sync(\Input::get('hsware_item'));
                    foreach (\Input::get('hsware_item') as $item) {
                        $hsware_item = \HswareItem::find($item);
                        $hsware_item->status = 1;
                        $hsware_item->spare = 0;
                        $hsware_item->save();

                        $hslog = new \HswareComputerLog();
                        $hslog->hsware_id = $item;
                        $hslog->computer_id = $computer_id;
                        $hslog->updated_user = \Auth::user()->id;
                        $hslog->save();
                    }
                }
                if (\Input::get('software_group_id') > 0) {

                    $software_arr = \DB::table('software_group_item')
                            ->join('software_group', 'software_group_item.id', '=', 'software_group.group_id')
                            ->join('software_item', 'software_group.software_id', '=', 'software_item.id')
                            ->where('software_group_item.id', \Input::get('software_group_id'))
                            ->where('software_group_item.disabled', 0)
                            ->select(array(
                                'software_item.id as id'
                            ))
                            ->lists('id');
                    $computer_item->software()->sync($software_arr);
                    foreach ($software_arr as $item) {
                        $hslog = new \ComputerSoftwareLog();
                        $hslog->computer_id = $computer_id;
                        $hslog->software_id = $item;
                        $hslog->created_user = \Auth::user()->id;
                        $hslog->save();
                    }
                }
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function view($param) {
        if (!\Request::isMethod('post')) {
            $item = \DB::table('computer_item')
                    ->leftJoin('computer_user', 'computer_item.id', '=', 'computer_user.computer_id')
                    ->leftJoin('users', 'users.id', '=', 'computer_user.user_id')
                    ->leftJoin('position_item', 'position_item.id', '=', 'users.position_id')
                    ->where('computer_item.id', $param)
                    ->select(array(
                        'computer_item.id as id',
                        'computer_item.title as title',
                        'computer_item.company_id as company_id',
                        'computer_item.software_group_id as software_group_id',
                        'computer_item.serial_code as serial_code',
                        'computer_item.access_no as access_no',
                        'computer_item.type_id as type_id',
                        'computer_item.locations as locations',
                        'computer_item.ip_address as ip_address',
                        'computer_item.mac_lan as mac_lan',
                        'computer_item.mac_wireless as mac_wireless',
                        'computer_item.register_date as register_date',
                        'computer_item.disabled as disabled',
                        \DB::raw('CONCAT(users.firstname," ",users.lastname) as fullname'),
                        'position_item.title as position',
                        'users.id as user_id'
                    ))
                    ->first();
            $data = array(
                'title' => 'แก่ไข Computer ' . $item->title,
                'breadcrumbs' => array(
                    'ภาพรวมระบบ' => '',
                    'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                    'ระเบียนคอมพิวเตอร์' => 'mis/computer',
                    'แก่ไข Computer ' . $item->title => '#'
                ),
                'item' => $item,
                'company' => \Company::lists('title', 'id'),
                'place' => \Place::lists('title', 'id')
            );

            return \View::make('mod_mis.computer.admin.view', $data);
        } else {
            $rules = array(
                'company_id' => 'required',
                'title' => 'required',
                'ip_address' => 'ip'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $computer_item = \ComputerItem::find($param);
                $computer_item->company_id = \Input::get('company_id');
                $computer_item->software_group_id = (\Input::has('software_group_id') ? \Input::get('software_group_id') : 0);
                $computer_item->type_id = \Input::get('type_id');
                $computer_item->serial_code = trim(\Input::get('serial_code'));
                $computer_item->access_no = trim(\Input::get('access_no'));
                $computer_item->ip_address = trim(\Input::get('ip_address'));
                $computer_item->title = trim(\Input::get('title'));
                $computer_item->ip_address = trim(\Input::get('ip_address'));
                $computer_item->mac_lan = trim(\Input::get('mac_lan'));
                $computer_item->mac_wireless = trim(\Input::get('mac_wireless'));
                $computer_item->locations = \Input::get('locations');
                $computer_item->register_date = trim(\Input::get('register_date'));
                $computer_item->disabled = (\Input::has('disabled') ? 0 : 1);
                $computer_item->updated_user = \Auth::user()->id;
                $computer_item->save();
                $computer_id = $computer_item->id;
                if (\Input::has('user_item')) {
                    \DB::table('users')
                            ->join('computer_user', 'users.id', '=', 'computer_user.user_id')
                            ->where('computer_user.computer_id', $param)
                            ->update(array('users.computer_status' => 0));
                    $computer_item->users()->sync(\Input::get('user_item'));
                    foreach (\Input::get('user_item') as $uitem) {
                        $hsware_item = \User::find($uitem);
                        $hsware_item->computer_status = 1;
                        $hsware_item->save();
                    }
                }
                if (\Input::get('hsware_item') > 0) {
                    \DB::table('hsware_item')
                            ->join('computer_hsware', 'hsware_item.id', '=', 'computer_hsware.hsware_id')
                            ->where('computer_hsware.computer_id', $param)
                            ->update(array('hsware_item.status' => 0));
                    $computer_item->hsware()->sync(\Input::get('hsware_item'));
                    foreach (\Input::get('hsware_item') as $item) {
                        $hsware_item = \HswareItem::find($item);
                        $hsware_item->status = 1;
                        $hsware_item->save();

                        $hslog = new \HswareComputerLog();
                        $hslog->hsware_id = $item;
                        $hslog->computer_id = $computer_id;
                        $hslog->updated_user = \Auth::user()->id;
                        $hslog->save();
                    }
                }
                if (\Input::get('software_group_id') > 0) {

                    $software_arr = \DB::table('software_group_item')
                            ->join('software_group', 'software_group_item.id', '=', 'software_group.group_id')
                            ->join('software_item', 'software_group.software_id', '=', 'software_item.id')
                            ->where('software_group_item.id', \Input::get('software_group_id'))
                            ->where('software_group_item.disabled', 0)
                            ->select(array(
                                'software_item.id as id'
                            ))
                            ->lists('id');
                    $computer_item->software()->sync($software_arr);
                    foreach ($software_arr as $item) {
                        $hslog = new \ComputerSoftwareLog();
                        $hslog->computer_id = $computer_id;
                        $hslog->software_id = $item;
                        $hslog->created_user = \Auth::user()->id;
                        $hslog->save();
                    }
                }
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function delete($param) {
        $computer_item = \ComputerItem::find($param);

        if (\DB::table('users')
                        ->join('computer_user', 'users.id', '=', 'computer_user.user_id')
                        ->where('computer_user.computer_id', $param)->count() > 0) {

            $user_item = \DB::table('users')
                            ->join('computer_user', 'users.id', '=', 'computer_user.user_id')
                            ->where('computer_user.computer_id', $param)->first();

            if ($computer_item->type_id == 1) {
                \DB::table('users')
                        ->join('computer_user', 'users.id', '=', 'computer_user.user_id')
                        ->where('computer_user.computer_id', $param)
                        ->update(array('users.computer_status' => 0));
            } else {
                \DB::table('users')
                        ->join('computer_user', 'users.id', '=', 'computer_user.user_id')
                        ->where('computer_user.computer_id', $param)
                        ->update(array('users.notebook_status' => 0));
            }

            \DB::table('computer_user')
                    ->where('computer_id', $param)
                    ->where('user_id', $user_item->user_id)
                    ->delete();
        }

//        if (\DB::table('hsware_item')
//                        ->join('computer_hsware', 'hsware_item.id', '=', 'computer_hsware.hsware_id')
//                        ->where('computer_hsware.computer_id', $param)->count() > 0) {

        $hsware_item = \DB::table('hsware_item')
                        ->join('computer_hsware', 'hsware_item.id', '=', 'computer_hsware.hsware_id')
                        ->where('computer_hsware.computer_id', $param)->first();

        \DB::table('hsware_item')
                ->join('computer_hsware', 'hsware_item.id', '=', 'computer_hsware.hsware_id')
                ->where('computer_hsware.computer_id', $param)
                ->update(array('hsware_item.status' => 0));

        \DB::table('computer_hsware')
                ->where('computer_id', $param)
                ->delete();
//        }

        if (\DB::table('computer_software')
                        ->where('computer_id', $param)->count() > 0) {
            \DB::table('computer_software')
                    ->where('computer_id', $param)
                    ->delete();
        }

        $computer_item->delete();
        return \Response::json(array(
                    'error' => array(
                        'status' => true,
                        'message' => 'ลบรายการสำเร็จ',
                        'redirect' => 'mis/computer'
                    ), 200));
    }

    public function deleteuser($param) {
        $computer_item = \ComputerItem::find($param);

        if (\DB::table('users')
                        ->join('computer_user', 'users.id', '=', 'computer_user.user_id')
                        ->where('computer_user.computer_id', $param)->count() > 0) {

            $user_item = \DB::table('users')
                            ->join('computer_user', 'users.id', '=', 'computer_user.user_id')
                            ->where('computer_user.computer_id', $param)->first();

            if ($computer_item->type_id == 1) {
                \DB::table('users')
                        ->join('computer_user', 'users.id', '=', 'computer_user.user_id')
                        ->where('computer_user.computer_id', $param)
                        ->update(array('users.computer_status' => 0));
            } elseif ($computer_item->type_id == 2) {
                \DB::table('users')
                        ->join('computer_user', 'users.id', '=', 'computer_user.user_id')
                        ->where('computer_user.computer_id', $param)
                        ->update(array('users.notebook_status' => 0));
            }
            \DB::table('computer_user')
                    ->where('computer_id', $param)
                    ->where('user_id', $user_item->user_id)
                    ->delete();
        }

        return \Response::json(array(
                    'error' => array(
                        'status' => true,
                        'message' => 'ลบรายการสำเร็จ',
                        'redirect' => 'mis/computer/edit/' . $param
                    ), 200));
    }

    public function export($param) {
        $item = \DB::table('computer_item')
                ->leftJoin('computer_user', 'computer_item.id', '=', 'computer_user.computer_id')
                ->leftJoin('users', 'users.id', '=', 'computer_user.user_id')
                ->leftJoin('position_item', 'position_item.id', '=', 'users.position_id')
                ->leftJoin('company', 'computer_item.company_id', '=', 'company.id')
                ->leftJoin('place', 'computer_item.locations', '=', 'place.id')
                ->leftJoin('supplier_item', 'computer_item.supplier_id', '=', 'supplier_item.id')
                ->where('computer_item.id', $param)
                ->select(array(
                    'computer_item.id as id',
                    'computer_item.title as title',
                    'company.title as company',
                    'computer_item.company_id as company_id',
                    'computer_item.nb_model as nb_model',
                    'computer_item.nb_submodel as nb_submodel',
                    'computer_item.serial_code as serial_code',
                    'computer_item.access_no as access_no',
                    'computer_item.type_id as type_id',
                    'computer_item.locations as locations',
                    'computer_item.floor as floor',
                    'computer_item.ip_address as ip_address',
                    'computer_item.mac_lan as mac_lan',
                    'computer_item.mac_wireless as mac_wireless',
                    'computer_item.register_date as register_date',
                    'place.title as place',
                    'position_item.title as position',
                    'supplier_item.title as supplier',
                    'computer_item.disabled as disabled',
                    \DB::raw('CONCAT(users.firstname," ",users.lastname) as fullname'),
                    'position_item.title as position'
                ))
                ->first();

        $ma_item = \DB::select('call getRepairingList(' . $param . ')');
        $data = array(
            'item' => $item,
            'ma' => $ma_item,
            'model' => 'Notebook ' . \HswareModel::getName($item->nb_model) . ' ' . \HswareModel::getName($item->nb_submodel),
            'software' => \DB::select('call getListComputerSoftware(' . $param . ')')
        );
        if ($item->company_id == 1) {
            return \View::make('mod_mis.computer.admin.word_export_arf', $data);
        } else {
            return \View::make('mod_mis.computer.admin.word_export_att', $data);
        }
    }

}
