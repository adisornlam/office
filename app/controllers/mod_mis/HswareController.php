<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com
 */

namespace App\Controllers;

/**
 * Description of HswareController
 *
 * @author ComputerController
 */
class HswareController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('auth', array('except' => '/login'));
    }

    public function index() {
        $data = array(
            'title' => 'รายการ Hardware & Software',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'รายการ Hardware & Software' => '#'
            ),
            'company' => \Company::lists('title', 'id'),
            'group' => \HswareGroup::lists('title', 'id')
        );
        return \View::make('mod_mis.hsware.admin.index', $data);
    }

    public function listall() {
        $hsware_item = \DB::table('hsware_item')
                ->join('hsware_group', 'hsware_item.group_id', '=', 'hsware_group.id')
                ->join('hsware_model', 'hsware_item.model_id', '=', 'hsware_model.id')
                ->join('company', 'hsware_item.company_id', '=', 'company.id')
                ->leftJoin('computer_hsware', 'hsware_item.id', '=', 'computer_hsware.hsware_id')
                ->leftJoin('computer_item', 'computer_item.id', '=', 'computer_hsware.computer_id')
                ->leftJoin('computer_user', 'computer_item.id', '=', 'computer_user.computer_id')
                ->leftJoin('users', 'users.id', '=', 'computer_user.user_id')
                ->leftJoin('place', 'hsware_item.locations', '=', 'place.id');

        if (\Input::has('group_id')) {
            $hsware_item->where('hsware_item.group_id', \Input::get('group_id'));
        }
        if (\Input::has('company_id')) {
            $hsware_item->where('hsware_item.company_id', \Input::get('company_id'));
        }
        if (\Input::has('status')) {
            $hsware_item->where('hsware_item.status', \Input::get('status'));
        }
        $hsware_item->select(array(
            'hsware_item.id as id',
            'hsware_item.id as item_id',
            'hsware_item.serial_code as serial_code',
            'hsware_model.title as title',
            'computer_item.title as computer_title',
            \DB::raw('CONCAT(users.firstname," ",users.lastname) as fullname'),
            'company.title as company',
            'hsware_group.title as group_title',
            'hsware_item.warranty_date as warranty_date',
            'hsware_item.register_date as register_date',
            'hsware_item.created_user as created_user',
            'hsware_item.updated_user as updated_user',
            'place.title as locations',
            'hsware_item.disabled as disabled',
            'hsware_item.status as status'
        ));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="{{\URL::to("mis/hsware/edit/$id")}}" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="{{\URL::to("mis/hsware/export/$id")}}" title="พิมพ์ระเบียน" target="_blank"><i class="fa fa-print"></i> พิมพ์ระเบียน</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/hsware/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($hsware_item)
                        ->edit_column('id', $link)
                        ->edit_column('status', '@if($status==1) <span class="label label-success">Used</span> @else <span class="label label-warning">Inactive</span> @endif')
                        ->edit_column('warranty_date', '@if($warranty_date=="0000-00-00") LT @elseif($warranty_date) {{$warranty_date}} @else LT @endif')
                        ->edit_column('title', function($result_obj) {
                            $str = '<a href="' . \URL::to('mis/hsware/view/' . $result_obj->item_id . '') . '">' . $result_obj->title . ' ' . $this->option_item($result_obj->item_id) . '</a>';
                            return $str;
                        })
                        ->edit_column('created_user', '{{\User::find($created_user)->username}}')
                        ->edit_column('updated_user', '{{($updated_user?\User::find($updated_user)->username:"")}}')
                        ->make(true);
    }

    public function group() {
        $data = array(
            'title' => 'รายการกลุ่มอุปกรณ์',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => 'backend',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'ระเบียนคอมพิวเตอร์' => 'mis/computer',
                'รายการอุปกรณ์' => 'mis/hsware',
                'รายการกลุ่มอุปกรณ์' => '#'
            )
        );

        return \View::make('mod_mis.hsware.admin.group', $data);
    }

    public function group_listall() {
        $hsware_group = \HswareGroup::select(array('id', 'title', 'limit_stock', 'remark', 'disabled'));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/hsware/group/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/hsware/group/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($hsware_group)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function model() {
        $data = array(
            'title' => 'รายการยี่ห้อ/รุ่น',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => 'backend',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'รายการอุปกรณ์' => 'mis/hsware',
                'รายการกลุ่มอุปกรณ์' => 'mis/hsware/group',
                'รายการยี่ห้อ/รุ่น' => '#'
            )
        );

        return \View::make('mod_mis.hsware.admin.model', $data);
    }

    public function model_sub($param) {
        $item = \HswareModel::find($param);
        $data = array(
            'title' => 'รายการรุ่น ' . $item->title,
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => 'backend',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'รายการอุปกรณ์' => 'mis/hsware',
                'รายการกลุ่มอุปกรณ์' => 'mis/hsware/group',
                'รายการยี่ห้อ/รุ่น' => 'mis/hsware/group/model',
                $item->title => '#'
            )
        );

        return \View::make('mod_mis.hsware.admin.model_sub', $data);
    }

    public function model_listall() {
        $hsware_group = \DB::table('hsware_model')
                ->join('hsware_group', 'hsware_model.group_id', '=', 'hsware_group.id')
                ->join('hsware_model_hierarchy', 'hsware_model.id', '=', 'hsware_model_hierarchy.hsware_model_id')
                ->where('hsware_model_hierarchy.hsware_model_parent_id', 0)
                ->select(array('hsware_model.id as id', 'hsware_model.id as item_id', 'hsware_model.title as title', 'hsware_group.title as group', 'hsware_model.disabled as disabled'));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/hsware/group/model/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/hsware/group/model/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($hsware_group)
                        ->edit_column('id', $link)
                        ->edit_column('title', function($result_obj) {
                            $str = '<a href="' . \URL::to('mis/hsware/group/model/sub/' . $result_obj->item_id . '') . '">' . $result_obj->title . '</a>';
                            return $str;
                        })
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function model_sub_listall($param) {
        $hsware_group = \DB::table('hsware_model')
                ->join('hsware_model_hierarchy', 'hsware_model.id', '=', 'hsware_model_hierarchy.hsware_model_id')
                ->where('hsware_model_hierarchy.hsware_model_parent_id', $param)
                ->select(array('hsware_model.id as id', 'hsware_model.title as title', 'hsware_model.disabled as disabled'));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/hsware/group/model/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/hsware/group/model/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($hsware_group)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function group_add() {
        if (!\Request::isMethod('post')) {
            return \View::make('mod_mis.hsware.admin.group_add');
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
            return \View::make('mod_mis.hsware.admin.group_edit', $data);
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
                            'redirect' => 'mis/hsware/group'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function model_add() {
        if (!\Request::isMethod('post')) {
            return \View::make('mod_mis.hsware.admin.model_add');
        } else {
            $rules = array(
                'title' => 'required',
                'group_id' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $hsware_model = new \HswareModel();
                $hsware_model->title = trim(\Input::get('title'));
                $hsware_model->group_id = \Input::get('group_id');
                $hsware_model->disabled = (\Input::has('disabled') ? 0 : 1);
                $hsware_model->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function model_sub_add() {
        if (!\Request::isMethod('post')) {
            return \View::make('mod_mis.hsware.admin.model_sub_add');
        } else {
            $rules = array(
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
                $hsware_model = new \HswareModel();
                $hsware_model->title = trim(\Input::get('title'));
                $hsware_model->disabled = (\Input::has('disabled') ? 0 : 1);
                $hsware_model->save();
                $hsware_model_id = $hsware_model->id;

                $hi = new \HswareModelHierarchy();
                $hi->hsware_model_id = $hsware_model_id;
                $hi->hsware_model_parent_id = \Input::get('parent_id');
                $hi->save();

                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function model_dialog_add() {
        if (!\Request::isMethod('post')) {
            return \View::make('mod_mis.hsware.admin.dialog_model_add');
        } else {
            $rules = array(
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
                $hsware_model = new \HswareModel();
                $hsware_model->title = trim(\Input::get('title'));
                $hsware_model->group_id = \Input::get('group_id');
                $hsware_model->disabled = 1;
                $hsware_model->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function model_edit($param) {
        if (!\Request::isMethod('post')) {
            $data = array(
                'item' => \HswareModel::find($param)
            );
            return \View::make('mod_mis.hsware.admin.model_edit', $data);
        } else {
            $rules = array(
                'title' => 'required',
                'group_id' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $hsware_model = \HswareModel::find($param);
                $hsware_model->title = trim(\Input::get('title'));
                $hsware_model->group_id = \Input::get('group_id');
                $hsware_model->disabled = (\Input::has('disabled') ? 0 : 1);
                $hsware_model->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function model_delete($param) {
        try {
            \HswareModel::find($param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'mis/hsware/group/model'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function dialog() {
        $group = \HswareGroup::lists('title', 'id');
        $data = array(
            'group' => $group
        );
        return \View::make('mod_mis.hsware.admin.dialog_add', $data);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            $group = \HswareGroup::find(\Input::get('group_id'));
            $data = array(
                'title' => 'เพิ่มรายการ' . (\Input::has('spare') ? 'อะไหล่' : 'อุปกรณ์') . ' ' . $group->title,
                'breadcrumbs' => array(
                    'ภาพรวมระบบ' => 'backend',
                    'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                    'รายการอุปกรณ์' => 'mis/hsware',
                    'เพิ่มรายการอุปกรณ์' => '#'
                ),
                'company' => \Company::lists('title', 'id'),
                'place' => \Place::lists('title', 'id'),
                'spec_label' => \DB::table('hsware_spec_label')
                        ->where('group_id', \Input::get('group_id'))
                        ->get()
            );

            return \View::make('mod_mis.hsware.admin.add', $data);
        } else {
            $rules = array(
                'group_id' => 'required',
                'photo1' => 'image|mimes:jpeg,png|max:512',
                'photo2' => 'image|mimes:jpeg,png|max:512',
                'photo3' => 'image|mimes:jpeg,png|max:512',
                'photo4' => 'image|mimes:jpeg,png|max:512',
                'photo5' => 'image|mimes:jpeg,png|max:512'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $photo1 = \Input::file('photo1');
                $photo2 = \Input::file('photo2');
                $photo3 = \Input::file('photo3');
                $photo4 = \Input::file('photo4');
                $photo5 = \Input::file('photo5');

                $destinationPath = 'uploads/hsware/' . date('Ymd') . '/';
                if ($photo1) {
                    $up = $this->upload_photo($photo1, $destinationPath);
                    $photo_1 = $up['full'];
                } else {
                    $photo_1 = NULL;
                }

                if ($photo2) {
                    $up = $this->upload_photo($photo2, $destinationPath);
                    $photo_2 = $up['full'];
                } else {
                    $photo_2 = NULL;
                }

                if ($photo3) {
                    $up = $this->upload_photo($photo3, $destinationPath);
                    $photo_3 = $up['full'];
                } else {
                    $photo_3 = NULL;
                }

                if ($photo4) {
                    $up = $this->upload_photo($photo4, $destinationPath);
                    $photo_4 = $up['full'];
                } else {
                    $photo_4 = NULL;
                }

                if ($photo5) {
                    $up = $this->upload_photo($photo5, $destinationPath);
                    $photo_5 = $up['full'];
                } else {
                    $photo_5 = NULL;
                }

                for ($i = 0; $i < \Input::get('count'); $i++) {
                    $hsware_item = new \HswareItem();
                    $hsware_item->group_id = \Input::get('group_id');
                    $hsware_item->company_id = \Input::get('company_id');
                    $hsware_item->serial_code = trim(\Input::get('serial_code'));
                    $hsware_item->serial_no = trim(\Input::get('serial_no'));
                    $hsware_item->access_no = trim(\Input::get('access_no'));
                    $hsware_item->model_id = \Input::get('model_id');
                    $hsware_item->title = trim(\Input::get('title'));
                    $hsware_item->spec_value_1 = trim(\Input::get('spec_value_1'));
                    $hsware_item->spec_value_2 = trim(\Input::get('spec_value_2'));
                    $hsware_item->spec_value_3 = trim(\Input::get('spec_value_3'));
                    $hsware_item->spec_value_4 = trim(\Input::get('spec_value_4'));
                    $hsware_item->spec_value_5 = trim(\Input::get('spec_value_5'));
                    $hsware_item->spec_value_6 = trim(\Input::get('spec_value_6'));
                    $hsware_item->spec_value_7 = trim(\Input::get('spec_value_7'));
                    $hsware_item->spec_value_8 = trim(\Input::get('spec_value_8'));
                    $hsware_item->spec_value_9 = trim(\Input::get('spec_value_9'));
                    $hsware_item->spec_value_10 = trim(\Input::get('spec_value_10'));
                    $hsware_item->spec_value_11 = trim(\Input::get('spec_value_11'));
                    $hsware_item->spec_value_12 = trim(\Input::get('spec_value_12'));
                    $hsware_item->spec_value_13 = trim(\Input::get('spec_value_13'));
                    $hsware_item->spec_value_14 = trim(\Input::get('spec_value_14'));
                    $hsware_item->spec_value_15 = trim(\Input::get('spec_value_15'));
                    $hsware_item->spec_value_16 = trim(\Input::get('spec_value_16'));
                    $hsware_item->spec_value_17 = trim(\Input::get('spec_value_17'));
                    $hsware_item->spec_value_18 = trim(\Input::get('spec_value_18'));
                    $hsware_item->spec_value_19 = trim(\Input::get('spec_value_19'));
                    $hsware_item->spec_value_20 = trim(\Input::get('spec_value_20'));
                    $hsware_item->spec_value_21 = trim(\Input::get('spec_value_21'));
                    $hsware_item->spec_value_22 = trim(\Input::get('spec_value_22'));
                    $hsware_item->spec_value_23 = trim(\Input::get('spec_value_23'));
                    $hsware_item->spec_value_24 = trim(\Input::get('spec_value_24'));
                    $hsware_item->spec_value_25 = trim(\Input::get('spec_value_25'));
                    $hsware_item->spec_value_26 = trim(\Input::get('spec_value_26'));
                    $hsware_item->spec_value_27 = trim(\Input::get('spec_value_27'));
                    $hsware_item->spec_value_28 = trim(\Input::get('spec_value_28'));
                    $hsware_item->spec_value_29 = trim(\Input::get('spec_value_29'));
                    $hsware_item->spec_value_30 = trim(\Input::get('spec_value_30'));
                    $hsware_item->spec_value_31 = trim(\Input::get('spec_value_31'));
                    $hsware_item->spec_value_32 = trim(\Input::get('spec_value_32'));
                    $hsware_item->spec_value_33 = trim(\Input::get('spec_value_33'));
                    $hsware_item->spec_value_34 = trim(\Input::get('spec_value_34'));
                    $hsware_item->photo1 = $photo_1;
                    $hsware_item->photo2 = $photo_2;
                    $hsware_item->photo3 = $photo_3;
                    $hsware_item->photo4 = $photo_4;
                    $hsware_item->photo5 = $photo_5;
                    $hsware_item->ip_address = trim(\Input::get('ip_address'));
                    $hsware_item->locations = trim(\Input::get('locations'));
                    $hsware_item->register_date = trim(\Input::get('register_date'));
                    $hsware_item->warranty_date = (\Input::get('warranty_date') != '' ? trim(\Input::get('warranty_date')) : NULL);
                    $hsware_item->spare = (\Input::has('spare') ? 1 : 0);
                    $hsware_item->disabled = (\Input::has('disabled') ? 0 : 1);
                    $hsware_item->created_user = \Auth::user()->id;
                    $hsware_item->save();
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
        $item = \HswareItem::find($param);
        $group_item = \HswareGroup::find($item->group_id);
        $option = \DB::table('hsware_item')
                ->join('hsware_spec_label', 'hsware_item.group_id', '=', 'hsware_spec_label.group_id')
                ->where('hsware_item.id', $param)
                ->select('hsware_item.*', 'hsware_spec_label.title as title', 'hsware_spec_label.option_id as option_id', 'hsware_spec_label.name as name')
                ->get();
        $data = array(
            'title' => 'รายละเอียด ' . $group_item->title . ' ' . \HswareItem::get_hsware($param),
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => 'backend',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'ระเบียนคอมพิวเตอร์' => 'mis/computer',
                'รายการอุปกรณ์' => 'mis/hsware',
                $item->title => '#'
            ),
            'item' => $item,
            'company' => \Company::find($item->company_id),
            'spec_label' => \DB::table('hsware_spec_label')
                    ->where('group_id', \Input::get('group_id'))
                    ->get(),
            'option' => $option
        );
        return \View::make('mod_mis.hsware.admin.view', $data);
    }

    public function edit($param) {
        if (!\Request::isMethod('post')) {
            $item = \HswareItem::find($param);
            $group = \HswareGroup::find($item->group_id);
            $option = \DB::table('hsware_item')
                    ->join('hsware_spec_label', 'hsware_item.group_id', '=', 'hsware_spec_label.group_id')
                    ->where('hsware_item.id', $param)
                    ->select('hsware_item.*', 'hsware_spec_label.title as title', 'hsware_spec_label.option_id as option_id', 'hsware_spec_label.name as name')
                    ->get();
            $data = array(
                'title' => 'แก้ไขรายการ' . (\Input::has('spare') ? 'อะไหล่' : 'อุปกรณ์') . ' ' . $group->title,
                'breadcrumbs' => array(
                    'ภาพรวมระบบ' => 'backend',
                    'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                    'รายการอุปกรณ์' => 'mis/hsware',
                    'แก้ไข ' . $item->title => '#'
                ),
                'item' => $item,
                'group' => $group,
                'company' => \Company::lists('title', 'id'),
                'place' => \Place::lists('title', 'id'),
                'spec_label' => \DB::table('hsware_spec_label')
                        ->where('group_id', $item->group_id)
                        ->get(),
                'option' => $option
            );
            return \View::make('mod_mis.hsware.admin.edit', $data);
        } else {
            $rules = array(
                'photo1' => 'image|mimes:jpeg,png|max:512',
                'photo2' => 'image|mimes:jpeg,png|max:512',
                'photo3' => 'image|mimes:jpeg,png|max:512',
                'photo4' => 'image|mimes:jpeg,png|max:512',
                'photo5' => 'image|mimes:jpeg,png|max:512'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $photo1 = \Input::file('photo1');
                $photo2 = \Input::file('photo2');
                $photo3 = \Input::file('photo3');
                $photo4 = \Input::file('photo4');
                $photo5 = \Input::file('photo5');

                $destinationPath = 'uploads/hsware/' . date('Ymd') . '/';
                if ($photo1) {
                    $up = $this->upload_photo($photo1, $destinationPath);
                    $photo_1 = $up['full'];
                } else {
                    $photo_1 = \Input::get('photo1_hidden');
                }

                if ($photo2) {
                    $up = $this->upload_photo($photo2, $destinationPath);
                    $photo_2 = $up['full'];
                } else {
                    $photo_2 = \Input::get('photo2_hidden');
                }

                if ($photo3) {
                    $up = $this->upload_photo($photo3, $destinationPath);
                    $photo_3 = $up['full'];
                } else {
                    $photo_3 = \Input::get('photo3_hidden');
                }

                if ($photo4) {
                    $up = $this->upload_photo($photo4, $destinationPath);
                    $photo_4 = $up['full'];
                } else {
                    $photo_4 = \Input::get('photo4_hidden');
                }

                if ($photo5) {
                    $up = $this->upload_photo($photo5, $destinationPath);
                    $photo_5 = $up['full'];
                } else {
                    $photo_5 = \Input::get('photo5_hidden');
                }

                $hsware_item = \HswareItem::find($param);
                $hsware_item->group_id = \Input::get('group_id');
                $hsware_item->company_id = \Input::get('company_id');
                $hsware_item->serial_code = trim(\Input::get('serial_code'));
                $hsware_item->serial_no = trim(\Input::get('serial_no'));
                $hsware_item->access_no = trim(\Input::get('access_no'));
                $hsware_item->model_id = \Input::get('model_id');
                $hsware_item->title = trim(\Input::get('title'));
                $hsware_item->spec_value_1 = trim(\Input::get('spec_value_1'));
                $hsware_item->spec_value_2 = trim(\Input::get('spec_value_2'));
                $hsware_item->spec_value_3 = trim(\Input::get('spec_value_3'));
                $hsware_item->spec_value_4 = trim(\Input::get('spec_value_4'));
                $hsware_item->spec_value_5 = trim(\Input::get('spec_value_5'));
                $hsware_item->spec_value_6 = trim(\Input::get('spec_value_6'));
                $hsware_item->spec_value_7 = trim(\Input::get('spec_value_7'));
                $hsware_item->spec_value_8 = trim(\Input::get('spec_value_8'));
                $hsware_item->spec_value_9 = trim(\Input::get('spec_value_9'));
                $hsware_item->spec_value_10 = trim(\Input::get('spec_value_10'));
                $hsware_item->spec_value_11 = trim(\Input::get('spec_value_11'));
                $hsware_item->spec_value_12 = trim(\Input::get('spec_value_12'));
                $hsware_item->spec_value_13 = trim(\Input::get('spec_value_13'));
                $hsware_item->spec_value_14 = trim(\Input::get('spec_value_14'));
                $hsware_item->spec_value_15 = trim(\Input::get('spec_value_15'));
                $hsware_item->spec_value_16 = trim(\Input::get('spec_value_16'));
                $hsware_item->spec_value_17 = trim(\Input::get('spec_value_17'));
                $hsware_item->spec_value_18 = trim(\Input::get('spec_value_18'));
                $hsware_item->spec_value_19 = trim(\Input::get('spec_value_19'));
                $hsware_item->spec_value_20 = trim(\Input::get('spec_value_20'));
                $hsware_item->spec_value_21 = trim(\Input::get('spec_value_21'));
                $hsware_item->spec_value_22 = trim(\Input::get('spec_value_22'));
                $hsware_item->spec_value_23 = trim(\Input::get('spec_value_23'));
                $hsware_item->spec_value_24 = trim(\Input::get('spec_value_24'));
                $hsware_item->spec_value_25 = trim(\Input::get('spec_value_25'));
                $hsware_item->spec_value_26 = trim(\Input::get('spec_value_26'));
                $hsware_item->spec_value_27 = trim(\Input::get('spec_value_27'));
                $hsware_item->spec_value_28 = trim(\Input::get('spec_value_28'));
                $hsware_item->spec_value_29 = trim(\Input::get('spec_value_29'));
                $hsware_item->spec_value_30 = trim(\Input::get('spec_value_30'));
                $hsware_item->spec_value_31 = trim(\Input::get('spec_value_31'));
                $hsware_item->spec_value_32 = trim(\Input::get('spec_value_32'));
                $hsware_item->spec_value_33 = trim(\Input::get('spec_value_33'));
                $hsware_item->spec_value_34 = trim(\Input::get('spec_value_34'));
                $hsware_item->photo1 = $photo_1;
                $hsware_item->photo2 = $photo_2;
                $hsware_item->photo3 = $photo_3;
                $hsware_item->photo4 = $photo_4;
                $hsware_item->photo5 = $photo_5;
                $hsware_item->ip_address = trim(\Input::get('ip_address'));
                $hsware_item->locations = trim(\Input::get('locations'));
                $hsware_item->register_date = trim(\Input::get('register_date'));
                $hsware_item->warranty_date = trim(\Input::get('warranty_date'));
                $hsware_item->spare = (\Input::has('spare') ? 1 : 0);
                $hsware_item->disabled = (\Input::has('disabled') ? 0 : 1);
                $hsware_item->updated_user = \Auth::user()->id;
                $hsware_item->save();
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

            $item = \HswareItem::find($param);
            if ($item->photo1 != NULL || $item->photo1 != '') {
                \File::delete($item->photo1);
            }
            if ($item->photo2 != NULL || $item->photo2 != '') {
                \File::delete($item->photo2);
            }
            if ($item->photo3 != NULL || $item->photo3 != '') {
                \File::delete($item->photo3);
            }
            if ($item->photo4 != NULL || $item->photo4 != '') {
                \File::delete($item->photo4);
            }
            if ($item->photo5 != NULL || $item->photo5 != '') {
                \File::delete($item->photo5);
            }
            \HswareItem::find($param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'mis/hsware'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function export($param) {
        $hsware_item = \DB::table('hsware_item')
                ->join('hsware_group', 'hsware_item.group_id', '=', 'hsware_group.id')
                ->join('hsware_model', 'hsware_item.model_id', '=', 'hsware_model.id')
                ->join('company', 'hsware_item.company_id', '=', 'company.id')
                ->leftJoin('computer_hsware', 'hsware_item.id', '=', 'computer_hsware.hsware_id')
                ->leftJoin('computer_item', 'computer_item.id', '=', 'computer_hsware.computer_id')
                ->leftJoin('computer_user', 'computer_item.id', '=', 'computer_user.computer_id')
                ->leftJoin('users', 'users.id', '=', 'computer_user.user_id')
                ->leftJoin('place', 'hsware_item.locations', '=', 'place.id')
                ->where('hsware_item.id', $param)
                ->select(array(
                    'hsware_item.id as id',
                    'hsware_item.id as item_id',
                    'hsware_item.serial_code as serial_code',
                    'hsware_model.title as title',
                    'computer_item.title as computer_title',
                    \DB::raw('CONCAT(users.firstname," ",users.lastname) as fullname'),
                    'company.title as company',
                    'hsware_group.title as group_title',
                    'hsware_item.warranty_date as warranty_date',
                    'hsware_item.register_date as register_date',
                    'hsware_item.created_user as created_user',
                    'hsware_item.updated_user as updated_user',
                    'place.title as locations',
                    'hsware_item.disabled as disabled',
                    'hsware_item.status as status'
                ))
                ->first();
        $data = array(
            'item' => $hsware_item
        );
    }

    private function upload_photo($file, $path) {
        $extension = $file->getClientOriginalExtension();
        $filename = str_random(32) . '.' . $extension;
        $smallfile = 'cover_' . $filename;
        $file->move($path, $filename);
        $img = \Image::make($path . $filename);
        $img->resize(250, null)->save($path . $smallfile);
        $photo = array(
            'full' => $path . $filename,
            'resize' => $path . $smallfile
        );
        return $photo;
    }

    public function option_item($param) {
        $option = \DB::table('hsware_item')
                ->join('hsware_spec_label', 'hsware_item.group_id', '=', 'hsware_spec_label.group_id')
                ->where('hsware_item.id', $param)
                ->select('hsware_item.*', 'hsware_spec_label.title as title', 'hsware_spec_label.option_id as option_id', 'hsware_spec_label.name as name')
                ->get();
        $str = '';
        foreach ($option as $item_option) {
            if ($item_option->option_id != 0) {
                $val = $item_option->{$item_option->name};
                $v = \HswareSpecOptionItem::find($val)->title;
            } else {
                $v = $item_option->{$item_option->name};
            }
            $str .= $v . ' ';
        }
        return $str;
    }

}
