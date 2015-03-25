<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com 
 */

namespace App\Controllers;

/**
 * Description of SoftwareController
 *
 * @author Administrator
 */
class SoftwareController extends \BaseController {

    public function index() {
        $data = array(
            'title' => 'รายการโปรแกรม/ซอฟต์แวร์',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'รายการ Software' => '#'
            ),
        );
        return \View::make('mod_mis.software.mis.index', $data);
    }

    public function listall() {
        $software = $computer_item = \DB::table('software_item')
                ->select(array('id', 'title', 'version', 'bit_os', 'free', 'disabled'))
                ->where('disabled', 0)
                ->orderBy('title', 'asc');

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/software/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/software/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($software)
                        ->edit_column('id', $link)
                        ->edit_column('free', '@if($free==0) <span class="label label-success">Free</span> @endif')
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            return \View::make('mod_mis.software.mis.add');
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
                $hsware_group = new \SoftwareItem();
                $hsware_group->title = trim(\Input::get('title'));
                $hsware_group->version = trim(\Input::get('version'));
                $hsware_group->bit_os = trim(\Input::get('bit_os'));
                $hsware_group->free = (\Input::has('free') ? 0 : 1);
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

    public function edit($param) {
        if (!\Request::isMethod('post')) {
            $item = \SoftwareItem::find($param);
            $data = array(
                'item' => $item
            );
            return \View::make('mod_mis.software.mis.edit', $data);
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
                $hsware_group = \SoftwareItem::find($param);
                $hsware_group->title = trim(\Input::get('title'));
                $hsware_group->version = trim(\Input::get('version'));
                $hsware_group->bit_os = trim(\Input::get('bit_os'));
                $hsware_group->free = (\Input::has('free') ? 0 : 1);
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

    public function delete($param) {
        \SoftwareItem::find($param)->delete();

        return \Response::json(array(
                    'error' => array(
                        'status' => true,
                        'message' => 'ลบรายการสำเร็จ',
                        'redirect' => 'mis/software'
                    ), 200));
    }

    public function group() {
        $data = array(
            'title' => 'รายการกลุ่ม Software',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'รายการ Software' => 'mis/software',
                'รายการกลุ่ม Software' => '#',
            ),
        );
        return \View::make('mod_mis.software.mis.group', $data);
    }

    public function group_listall() {
        $software = $computer_item = \DB::table('software_group_item')
                ->select(array('id', 'title', 'disabled'))
                ->where('disabled', 0)
                ->orderBy('title', 'asc');

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="' . \URL::to('mis/software/group/edit') . '/{{$id}}" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/software/group/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($software)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function group_add() {
        if (!\Request::isMethod('post')) {
            $data = array(
                'title' => 'รายการกลุ่ม Software',
                'breadcrumbs' => array(
                    'ภาพรวมระบบ' => '',
                    'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                    'รายการ Software' => 'mis/software',
                    'รายการกลุ่ม Software' => 'mis/software/group',
                    'เพิ่ม กลุ่ม Software' => '#',
                ),
            );
            return \View::make('mod_mis.software.mis.group_add', $data);
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
                $hsware_group = new \SoftwareGroupItem();
                $hsware_group->title = trim(\Input::get('title'));
                $hsware_group->save();
                $hsware_group_id = $hsware_group->id;
                if (\Input::get('software_id') > 0) {
                    foreach (\Input::get('software_id') as $item) {
                        $software_group = new \SoftwareGroup();
                        $software_group->group_id = $hsware_group_id;
                        $software_group->software_id = $item;
                        $software_group->save();
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

    public function group_edit($param) {
        if (!\Request::isMethod('post')) {
            $item = \SoftwareGroupItem::find($param);
            $software_group_arr = \SoftwareGroup::where('group_id', $param)->lists('software_id');
            $data = array(
                'title' => 'แก้ไข ' . $item->title,
                'breadcrumbs' => array(
                    'ภาพรวมระบบ' => '',
                    'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                    'รายการ Software' => 'mis/software',
                    'รายการกลุ่ม Software' => 'mis/software/group',
                    'แก้ไข กลุ่ม Software' => '#',
                ),
                'item' => $item,
                'software_arr' => $software_group_arr
            );
            return \View::make('mod_mis.software.mis.group_edit', $data);
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
                $hsware_group = \SoftwareGroupItem::find($param);
                $hsware_group->title = trim(\Input::get('title'));
                $hsware_group->save();
                $hsware_group_id = $hsware_group->id;

                if (\Input::get('software_id') > 0) {
                    \SoftwareGroup::where('group_id', $hsware_group_id)->delete();
                    foreach (\Input::get('software_id') as $item) {
                        $software_group = new \SoftwareGroup();
                        $software_group->group_id = $hsware_group_id;
                        $software_group->software_id = $item;
                        $software_group->save();
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

    public function group_delete($param) {
        \SoftwareGroup::where('group_id', $param)->delete();
        \SoftwareGroupItem::find($param)->delete();

        return \Response::json(array(
                    'error' => array(
                        'status' => true,
                        'message' => 'ลบรายการสำเร็จ',
                        'redirect' => 'mis/software/group'
                    ), 200));
    }

}
