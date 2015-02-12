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
            )
        );

        return \View::make('mod_mis.computer.admin.index', $data);
    }

    public function listall() {
        $hsware_item = \DB::table('computer_item')
                ->join('computer_user', 'computer_item.id', '=', 'computer_user.computer_id')
                ->join('users', 'users.id', '=', 'computer_user.user_id')
                ->join('computer_type', 'computer_item.type_id', '=', 'computer_type.id')
                ->join('company', 'computer_item.company_id', '=', 'company.id')
                ->select(array(
            'computer_item.id as id',
            'computer_item.id as item_id',
            'computer_item.title as title',
            \DB::raw('CONCAT(users.firstname," ",users.lastname) as fullname'),
            'company.title as company',
            'computer_item.disabled as disabled'
        ));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="{{\URL::to("mis/computer/edit/$id")}}" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/computer/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($hsware_item)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->edit_column('title', function($result_obj) {
                            $str = '<a href="' . \URL::to('mis/hsware/view/' . $result_obj->item_id . '') . '">' . $result_obj->title . ' ' . $this->option_item($result_obj->item_id) . '</a>';
                            return $str;
                        })
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
                    'ภาพรวมระบบ' => 'backend',
                    'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                    'ระเบียนคอมพิวเตอร์' => 'mis/computer',
                    'เพิ่ม Computer' => '#'
                ),
                'company' => \Company::lists('title', 'id')
            );

            return \View::make('mod_mis.computer.admin.add', $data);
        } else {
            $rules = array(
                'group_id' => 'required',
//                'title' => 'required',
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
                    $hsware_item->hsware_code = trim(\Input::get('hsware_code'));
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
                    $hsware_item->photo1 = $photo_1;
                    $hsware_item->photo2 = $photo_2;
                    $hsware_item->photo3 = $photo_3;
                    $hsware_item->photo4 = $photo_4;
                    $hsware_item->photo5 = $photo_5;
                    $hsware_item->desc = trim(\Input::get('desc'));
                    $hsware_item->register_date = trim(\Input::get('register_date'));
                    $hsware_item->warranty_date = (\Input::get('warranty_date') != '' ? trim(\Input::get('warranty_date')) : NULL);
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

}
