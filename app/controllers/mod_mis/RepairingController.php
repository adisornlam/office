<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com
 */

namespace App\Controllers;

/**
 * Description of RepairingController
 *
 * @author Administrator
 */
class RepairingController extends \BaseController {

    public function index() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data = array(
            'title' => 'รายการแจ้งซ่อมอุปกรณ์',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'รายการแจ้งซ่อมอุปกรณ์' => '#'
            )
        );
        if ($check->is('administrator')) {
            return \View::make('mod_users.repairing.admin.index', $data);
        } elseif ($check->is('mis')) {
            return \View::make('mod_mis.repairing.mis.index', $data);
        } elseif ($check->is('employee')) {
            return \View::make('mod_mis.repairing.employee.index', $data);
        }
    }

    public function listall() {
        $repairing = \DB::table('repairing_item')
                ->join('repairing_group', 'repairing_item.group_id', '=', 'repairing_group.id')
                ->leftJoin('users', 'repairing_item.created_user', '=', 'users.id');
        if (\Input::has('group_id')) {
            $repairing->where('repairing_item.group_id', \Input::get('group_id'));
        }
        $repairing->select(array(
            'repairing_item.id as id',
            'repairing_item.id as item_id',
            'repairing_item.title as title',
            'repairing_group.title as group_title',
            'repairing_item.disabled as disabled',
            'repairing_item.receive_user as receive_user',
            'repairing_item.created_user as created_user',
            'repairing_item.created_at as created_at'
        ));
        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/repairing/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/repairing/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($repairing)
                        ->edit_column('id', $link)
                        ->edit_column('title', function($result_obj) {
                            $str = '<a href="' . \URL::to('mis/repairing/view/' . $result_obj->item_id . '') . '" title="ดูรายการแจ้งซ่อม">' . $result_obj->title . '</a>';
                            return $str;
                        })
                        ->edit_column('receive_user', function($result_obj) {
                            $user = \User::find($result_obj->receive_user);
                            if ($user) {
                                $str = $user->firstname . ' ' . $user->lastname;
                            } else {
                                $str = '';
                            }
                            return $str;
                        })
                        ->edit_column('created_user', function($result_obj) {
                            $user = \User::find($result_obj->created_user);
                            if ($user) {
                                $str = $user->firstname . ' ' . $user->lastname;
                            } else {
                                $str = '';
                            }
                            return $str;
                        })
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function add() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        if (!\Request::isMethod('post')) {
            $data = array(
                'item' => null
            );
            if ($check->is('administrator')) {
                return \View::make('mod_users.admin.users.index', $data);
            } elseif ($check->is('mis')) {
                return \View::make('mod_mis.repairing.mis.add', $data);
            } elseif ($check->is('employee')) {
                return \View::make('mod_mis.repairing.employee.add', $data);
            }
        } else {
            $rules = array(
                'title' => 'required',
                'desc' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $repairing = new \RepairingItem();
                $repairing->title = trim(\Input::get('title'));
                $repairing->group_id = \Input::get('group_id');
                $repairing->desc = \Input::get('desc');
                $repairing->disabled = 0;
                $repairing->created_user = \Auth::user()->id;
                $repairing->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function view($param) {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data = array(
            'item' => \Supplier::find($param)
        );
        if ($check->is('administrator')) {
            return \View::make('mod_users.admin.users.view', $data);
        } elseif ($check->is('mis')) {
            return \View::make('mod_mis.repairing.mis.view', $data);
        } elseif ($check->is('employee')) {
            return \View::make('mod_mis.repairing.employee.view', $data);
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

    public function ma() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data = array(
            'title' => 'รายการ MA',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'รายการแจ้งซ่อมอุปกรณ์' => 'mis/repairing',
                'รายการ MA' => '#'
            )
        );
        if ($check->is('administrator')) {
            return \View::make('mod_users.repairing.admin.ma', $data);
        } elseif ($check->is('mis')) {
            return \View::make('mod_mis.repairing.mis.ma', $data);
        }
    }

    public function ma_listall() {
        $repairing = \DB::table('ma_item')
                ->join('ma_type', 'ma_item.type_id', '=', 'ma_type.id')
                ->leftJoin('computer_item', 'ma_item.computer_id', '=', 'computer_item.id')
                ->leftJoin('hsware_item', 'ma_item.hsware_id', '=', 'hsware_item.id')
                ->leftJoin('users', 'ma_item.created_user', '=', 'users.id')
                ->leftJoin('repairing_group', 'ma_item.group_id', '=', 'repairing_group.id')
                ->leftJoin('company', 'ma_item.company_id', '=', 'company.id');
        if (\Input::has('group_id')) {
            $repairing->where('ma_item.type_id', \Input::get('type_id'));
        }
        $repairing->select(array(
            'ma_item.id as id',
            'ma_item.id as item_id',
            'ma_item.title as title',
            'repairing_group.title as group_title',
            'company.title as company',
            'ma_item.status as status',
            'ma_item.created_user as created_user',
            'ma_item.created_at as created_at'
        ));
        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/repairing/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/repairing/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($repairing)
                        ->edit_column('id', $link)
                        ->edit_column('title', function($result_obj) {
                            $str = '<a href="' . \URL::to('mis/repairing/ma/view/' . $result_obj->item_id . '') . '" title="ดูรายการ MA">' . $result_obj->title . '</a>';
                            return $str;
                        })
                        ->edit_column('created_user', function($result_obj) {
                            $user = \User::find($result_obj->created_user);
                            if ($user) {
                                $str = $user->firstname . ' ' . $user->lastname;
                            } else {
                                $str = '';
                            }
                            return $str;
                        })
                        ->edit_column('status', function($result_obj) {
                            if ($result_obj->status == 0) {
                                $str = 'รับเรื่องแล้ว';
                            } elseif ($result_obj->status == 1) {
                                $str = 'กำลังดำเนินการ';
                            } elseif ($result_obj->status == 2) {
                                $str = 'เรียบร้อยแล้ว';
                            }
                            return $str;
                        })
                        ->make(true);
    }

    public function ma_dialog() {
        $data = array(
            'group' => \DB::table('repairing_group')->lists('title', 'id')
        );
        return \View::make('mod_mis.repairing.mis.dialog_ma_add', $data);
    }

    public function ma_add() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        if (!\Request::isMethod('post')) {
            if (\Input::get('group_id') == 1) {
                $group_id = \DB::table('computer_item')
                        ->where('computer_item.disabled', 0)
                        ->where('computer_item.type_id', 1)
                        ->select(array(
                            'computer_item.id as id',
                            \DB::raw('CONCAT(computer_item.serial_code," -- ",computer_item.title) as title')
                        ))
                        ->lists('title', 'id');
            } elseif (\Input::get('group_id') == 2) {
                $group_id = \DB::table('computer_item')
                        ->where('computer_item.disabled', 0)
                        ->where('computer_item.type_id', 2)
                        ->select(array(
                            'computer_item.id as id',
                            \DB::raw('CONCAT(computer_item.serial_code," -- ",computer_item.title) as title')
                        ))
                        ->lists('title', 'id');
            } elseif (\Input::get('group_id') == 3) {
                $group_id = \DB::table('hsware_item')
                        ->where('disabled', 0)
                        ->where('group_id', 24)
                        ->select(array(
                            'id',
                            'serial_code as title'
                        ))
                        ->lists('title', 'id');
            } elseif (\Input::get('group_id') == 4) {
                $group_id = \DB::table('hsware_item')
                        ->where('disabled', 0)
                        ->where('group_id', 14)
                        ->select(array(
                            'id',
                            'serial_code as title'
                        ))
                        ->lists('title', 'id');
            } elseif (\Input::get('group_id') == 5) {
                $group_id = \DB::table('hsware_item')
                        ->where('disabled', 0)
                        ->where('group_id', 13)
                        ->select(array(
                            'id',
                            'serial_code as title'
                        ))
                        ->lists('title', 'id');
            } else {
                $group_id = array('' => 'ไม่มีรายการ');
            }
            $data = array(
                'title' => 'เพิ่มรายการ MA',
                'breadcrumbs' => array(
                    'ภาพรวมระบบ' => '',
                    'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                    'รายการแจ้งซ่อมอุปกรณ์' => 'mis/repairing',
                    'รายการ MA' => 'mis/repairing/ma',
                    'เพิ่มรายการ MA' => '#'
                ),
                'computer' => $group_id
            );
            if ($check->is('administrator')) {
                return \View::make('mod_mis.admin.ma_add', $data);
            } elseif ($check->is('mis')) {
                return \View::make('mod_mis.repairing.mis.ma_add', $data);
            }
        } else {
            $rules = array(
                'title' => 'required',
                'computer_id' => 'required',
                'desc' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                if (\Input::get('group_id') <= 2) {
                    $computer_item = \ComputerItem::find(\Input::get('computer_id'));
                } else {
                    $computer_item = \HswareItem::find(\Input::get('computer_id'));
                }
                $ma_item = new \MaItem();
                $ma_item->group_id = \Input::get('group_id');
                $ma_item->company_id = $computer_item->company_id;
                $ma_item->computer_id = (\Input::get('group_id') <= 2 ? \Input::get('computer_id') : 0);
                $ma_item->hsware_id = (\Input::get('group_id') > 2 ? \Input::get('group_id') : 0);
                $ma_item->type_id = \Input::get('type_id');
                $ma_item->serial_no = 0;
                $ma_item->title = trim(\Input::get('title'));
                $ma_item->desc = \Input::get('desc');
                $ma_item->cost = trim(\Input::get('cost'));
                $ma_item->warranty = trim(\Input::get('warranty'));
                $ma_item->status = \Input::get('status');
                $ma_item->disabled = 0;
                $ma_item->created_user = \Auth::user()->id;
                $ma_item->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

}
