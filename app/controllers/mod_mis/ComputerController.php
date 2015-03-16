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
                ->join('computer_type', 'computer_item.type_id', '=', 'computer_type.id')
                ->join('company', 'computer_item.company_id', '=', 'company.id')
                ->select(array(
            'computer_item.id as id',
            'computer_item.id as item_id',
            'computer_item.serial_code as serial_code',
            'computer_item.title as title',
            \DB::raw('CONCAT(users.codes," ",users.firstname," ",users.lastname) as fullname'),
            'computer_item.ip_address as ip_address',
            'company.title as company',
            'computer_item.disabled as disabled'
        ));

        if (\Input::has('company_id')) {
            $computer_item->where('computer_item.company_id', \Input::get('company_id'));
        }

        if (\Input::has('status')) {
            $computer_item->where('computer_item.disabled', \Input::get('disabled'));
        }

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="{{\URL::to("mis/computer/edit/$id")}}" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="{{\URL::to("mis/computer/export/$id")}}" title="พิมพ์ระเบียน"><i class="fa fa-print"></i> พิมพ์ระเบียน</a></li>';
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

            return \View::make('mod_mis.computer.admin.add', $data);
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
                        'position_item.title as position'
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
        \DB::table('users')
                ->join('computer_user', 'users.id', '=', 'computer_user.user_id')
                ->where('computer_user.computer_id', $param)
                ->update(array('users.computer_status' => 0));
        $computer_item->users()->restore();

        \DB::table('hsware_item')
                ->join('computer_hsware', 'hsware_item.id', '=', 'computer_hsware.hsware_id')
                ->where('computer_hsware.computer_id', $param)
                ->update(array('hsware_item.status' => 0));
        $computer_item->hsware()->restore();
        $computer_item->delete();
        return \Response::json(array(
                    'error' => array(
                        'status' => true,
                        'message' => 'ลบรายการสำเร็จ',
                        'redirect' => 'mis/backend'
                    ), 200));
    }

    public function export($param) {
        $pdf = \App::make('dompdf');
        $pdf->loadView('mod_mis.computer.admin.pdf_export');
        return $pdf->download('computer.pdf');
    }

}
