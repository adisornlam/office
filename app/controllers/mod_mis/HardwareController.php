<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com 
 */

namespace App\Controllers;

/**
 * Description of HardwareController
 *
 * @author Administrator
 */
class HardwareController extends \BaseController {

    public function index() {
        $category = \DB::table('categories')
                ->select('categories.id as id', 'categories.title as title')
                ->join('category_hierarchy', 'categories.id', '=', 'category_hierarchy.category_id')
                ->where('category_hierarchy.category_parent_id', '=', 0)
                ->where('categories.type', '=', 'equipment_hardware')
                ->lists('title', 'id');

        $data = array(
            'category' => $category
        );
        $data = array(
            'title' => 'รายการคอมพิวเตอร์/อุปกรณ์',
            'category' => $category
        );
        return \View::make('mod_mis.hardware.index', $data);
    }

    public function listall() {
        if (\Input::has('category_id')) {
            $equipment = \Equipment::select(array(
                        'Equipment.id as id',
                        'categories.title as cat_title',
                        'Equipment.equipment_code as equipment_code',
                        'Equipment.title as title',
                        'Equipment.stock as stock',
                        'Equipment.register_date as register_date',
                        'users.username as created_user',
                        'users.username as updated_user',
                        'Equipment.disabled as disabled'
                    ))
                    ->join('categories', 'Equipment.category_id', '=', 'categories.id')
                    ->join('users', 'Equipment.created_user', '=', 'users.id')
                    ->where('categories.type', '=', 'equipment_hardware')
                    ->where('equipment.category_id', '=', \Input::get('category_id'));
        } else {
            $equipment = \Equipment::select(array(
                        'Equipment.id as id',
                        'categories.title as cat_title',
                        'Equipment.equipment_code as equipment_code',
                        'Equipment.title as title',
                        'Equipment.stock as stock',
                        'Equipment.register_date as register_date',
                        'users.username as created_user',
                        'users.username as updated_user',
                        'Equipment.disabled as disabled'
                    ))
                    ->join('categories', 'Equipment.category_id', '=', 'categories.id')
                    ->join('users', 'Equipment.created_user', '=', 'users.id')
                    ->where('categories.type', '=', 'equipment_hardware');
        }
        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="' . \URL::to('mis/backend/hardware/edit') . '/{{$id}}" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/backend/hardware/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($equipment)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function dialog() {
        $category = \DB::table('categories')
                ->select('categories.id as id', 'categories.title as title')
                ->join('category_hierarchy', 'categories.id', '=', 'category_hierarchy.category_id')
                ->where('category_hierarchy.category_parent_id', '=', 0)
                ->where('categories.type', '=', 'equipment_hardware')
                ->lists('title', 'id');

        $data = array(
            'category' => $category
        );
        return \View::make('mod_mis.hardware.equipment_dialog_add', $data);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            $category = \DB::table('categories')
                    ->select('categories.id as id', 'categories.title as title')
                    ->join('category_hierarchy', 'categories.id', '=', 'category_hierarchy.category_id')
                    ->where('category_hierarchy.category_parent_id', '=', 0)
                    ->where('categories.type', '=', 'equipment_hardware')
                    ->lists('title', 'id');
            $software = \Equipment::where('category_id', 6)->where('disabled', 0)->get();
            $data = array(
                'title' => 'เพิ่มอุปกรณ์',
                'breadcrumbs' => array(
                    'รายการคอมพิวเตอร์/อุปกรณ์' => 'mis/backend',
                    'เพิ่มอุปกรณ์' => '#'
                ),
                'category' => $category,
                'company' => \Company::lists('title', 'id'),
                'result' => \Equipmentspeclabel::where('category_id', \Input::get('category_id'))->get(),
                'software' => $software
            );
            return \View::make('mod_mis.hardware.equipment_add', $data);
        } else {
            $rules = array(
                'category_id' => 'required',
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
                $eqm = new \Equipment();
                $eqm->category_id = \Input::get('category_id');
                $eqm->company_id = \Input::get('company_id');
                $eqm->equipment_code = trim(\Input::get('equipment_code'));
                $eqm->serial_number = trim(\Input::get('serial_number'));
                $eqm->title = trim(\Input::get('title'));
                $eqm->color_name = trim(\Input::get('color_name'));
                $eqm->description = trim(\Input::get('description'));
                $eqm->register_date = trim(\Input::get('register_date'));
                $eqm->disabled = (\Input::has('disabled') ? 0 : 1);
                $eqm->created_user = \Auth::user()->id;
                $eqm->save();
                $emp_id = $eqm->id;

                if (\Input::has('software_id')) {
                    $stw = \Input::get('software_id');
                    foreach ($stw as $item_st) {
                        $st = new \Softwareinstall();
                        $st->software_id = $item_st;
                        $st->equipment_id = $emp_id;
                        $st->save();
                    }
                }
                $spec = \Input::get('spec');
                for ($i = 0; $i < 20; $i++) {
                    if (isset($spec[$i])) {
                        $inp = new \Equipmentspecvalue();
                        $inp->equipment_id = $emp_id;
                        $inp->equipment_spec_label_id = $i;
                        $inp->val = $spec[$i];
                        $inp->save();
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
            $item = \Equipment::find($param);
            $spec_value = \Equipmentspecvalue::where('equipment_id', $param)->orderBy('equipment_spec_label_id')->get();
            $category = \DB::table('categories')
                    ->select('categories.id as id', 'categories.title as title')
                    ->join('category_hierarchy', 'categories.id', '=', 'category_hierarchy.category_id')
                    ->where('category_hierarchy.category_parent_id', '=', 0)
                    ->where('categories.type', '=', 'equipment_hardware')
                    ->lists('title', 'id');
            $software = \Equipment::where('category_id', 6)->where('disabled', 0)->get();
            $software_install = \Softwareinstall::select('software_id')->where('equipment_id', $param)->lists('software_id');

            $data = array(
                'title' => 'แก้ไขอุปกรณ์',
                'breadcrumbs' => array(
                    'รายการคอมพิวเตอร์/อุปกรณ์' => 'mis/backend',
                    'แก้ไขอุปกรณ์' => '#',
                    $item->title => '#'
                ),
                'category' => $category,
                'company' => \Company::lists('title', 'id'),
                'result' => \Equipmentspeclabel::where('category_id', $item->category_id)->get(),
                'software' => $software,
                'software_install' => $software_install,
                'item' => $item,
                'spec_value' => $spec_value->toArray()
            );
            return \View::make('mod_mis.hardware.equipment_edit', $data);
        } else {
            $rules = array(
                'category_id' => 'required',
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
                $eqm = \Equipment::find(\Input::get('id'));
                $eqm->category_id = \Input::get('category_id');
                $eqm->company_id = \Input::get('company_id');
                $eqm->equipment_code = trim(\Input::get('equipment_code'));
                $eqm->serial_number = trim(\Input::get('serial_number'));
                $eqm->title = trim(\Input::get('title'));
                $eqm->color_name = trim(\Input::get('color_name'));
                $eqm->description = trim(\Input::get('description'));
                $eqm->register_date = trim(\Input::get('register_date'));
                $eqm->disabled = (\Input::has('disabled') ? 0 : 1);
                $eqm->updated_user = \Auth::user()->id;
                $eqm->save();
                $emp_id = $eqm->id;

                \Equipmentspecvalue::where('equipment_id', $emp_id)->delete();
                $spec = \Input::get('spec');
                for ($i = 0; $i < 20; $i++) {
                    if (isset($spec[$i])) {
                        $inp = new \Equipmentspecvalue();
                        $inp->equipment_id = $emp_id;
                        $inp->equipment_spec_label_id = $i;
                        $inp->val = $spec[$i];
                        $inp->save();
                    }
                }

                if (\Input::has('software_id')) {
                    \Softwareinstall::where('equipment_id', $emp_id)->delete();
                    $stw = \Input::get('software_id');
                    foreach ($stw as $item_st) {
                        $st = new \Softwareinstall();
                        $st->software_id = $item_st;
                        $st->equipment_id = $emp_id;
                        $st->save();
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
        try {
            \Equipment::find($param)->delete();
            \Softwareinstall::where('equipment_id', $param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'mis/backend'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function label() {
        $data = array(
            'title' => 'สเปคอุปกรณ์',
            'breadcrumbs' => array(
                'รายการคอมพิวเตอร์/อุปกรณ์' => 'mis/backend',
                'หมวดหมู่อุปกรณ์' => 'mis/backend/hardware/category',
                'สเปคอุปกรณ์' => '#'
            ),
        );
        return \View::make('mod_mis.hardware.label', $data);
    }

    public function label_listall() {
        $equipmentlabel = \DB::table('equipment_spec_label')
                ->select('equipment_spec_label.category_id as id', 'categories.title as cat_title')
                ->join('categories', 'equipment_spec_label.category_id', '=', 'categories.id')
                ->groupBy('categories.title');

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="' . \URL::to('mis/backend/hardware/label/edit') . '/{{$id}}" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/backend/hardware/label/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($equipmentlabel)
                        ->edit_column('cat_title', '<a href="{{\URL::to(\'mis/backend/hardware/label/view\')}}/{{$id}}">{{$cat_title}}</a>')
                        ->edit_column('id', $link)
                        ->make(true);
    }

    public function label_view($param) {
        $data = array(
            'title' => 'เพิ่มสเปคอุปกรณ์',
            'breadcrumbs' => array(
                'รายการคอมพิวเตอร์/อุปกรณ์' => 'mis/backend',
                'หมวดหมู่อุปกรณ์' => 'mis/backend/hardware/category',
                'รายการสเปคอุปกรณ์' => 'mis/backend/hardware/label',
                'แสดงสเปคอุปกรณ์' => '#'
            ),
            'result' => \Equipmentspeclabel::where('category_id', $param)->get()
        );
        return \View::make('mod_mis.hardware.label_view', $data);
    }

    public function label_listall_view() {
        $equipmentlabel = \DB::table('equipment_spec_label')
                ->select('id', 'title', 'disabled')
                ->where('category_id', \Input::get('category_id'));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/backend/hardware/spec/label/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/backend/hardware/spec/label/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($equipmentlabel)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function label_add() {
        if (!\Request::isMethod('post')) {
            $category = \DB::table('categories')
                    ->select('categories.id as id', 'categories.title as title')
                    ->join('category_hierarchy', 'Categories.id', '=', 'category_hierarchy.category_id')
                    ->where('category_hierarchy.category_parent_id', '=', 0)
                    ->lists('title', 'id');
            $data = array(
                'title' => 'เพิ่มสเปคอุปกรณ์',
                'breadcrumbs' => array(
                    'รายการคอมพิวเตอร์/อุปกรณ์' => 'mis/backend',
                    'หมวดหมู่อุปกรณ์' => 'mis/backend/hardware/category',
                    'รายการสเปคอุปกรณ์' => 'mis/backend/hardware/label',
                    'เพิ่มสเปคอุปกรณ์' => '#'
                ),
                'category' => $category
            );
            return \View::make('mod_mis.hardware.label_add', $data);
        } else {
            $rules = array(
                'category_id' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                for ($i = 1; $i <= 20; $i++) {
                    if (\Input::has(($i < 10 ? 'label_0' . $i : 'label_' . $i))) {
                        $eqm_spec_label = new \Equipmentspeclabel();
                        $eqm_spec_label->category_id = \Input::get('category_id');
                        $eqm_spec_label->title = \Input::get(($i < 10 ? 'label_0' . $i : 'label_' . $i));
                        $eqm_spec_label->save();
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

    public function label_edit($param) {
        if (!\Request::isMethod('post')) {
            $category = \DB::table('categories')
                    ->select('categories.id as id', 'categories.title as title')
                    ->join('category_hierarchy', 'Categories.id', '=', 'category_hierarchy.category_id')
                    ->where('category_hierarchy.category_parent_id', '=', 0)
                    ->lists('title', 'id');
            $data = array(
                'title' => 'เพิ่มสเปคอุปกรณ์',
                'breadcrumbs' => array(
                    'รายการคอมพิวเตอร์/อุปกรณ์' => 'mis/backend',
                    'หมวดหมู่อุปกรณ์' => 'mis/backend/hardware/category',
                    'รายการสเปคอุปกรณ์' => 'mis/backend/hardware/label',
                    'แก้ไขสเปคอุปกรณ์' => '#'
                ),
                'category' => $category,
                'item' => \Equipmentlabel::find($param)
            );
            return \View::make('mod_mis.hardware.label_edit', $data);
        } else {
            $rules = array(
                'category_id' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $eqm = \Equipmentlabel::find(\Input::get('id'));
                $eqm->category_id = \Input::get('category_id');
                $eqm->label_01 = trim(\Input::get('label_01'));
                $eqm->label_02 = trim(\Input::get('label_02'));
                $eqm->label_03 = trim(\Input::get('label_03'));
                $eqm->label_04 = trim(\Input::get('label_04'));
                $eqm->label_05 = trim(\Input::get('label_05'));
                $eqm->label_06 = trim(\Input::get('label_06'));
                $eqm->label_07 = trim(\Input::get('label_07'));
                $eqm->label_08 = trim(\Input::get('label_08'));
                $eqm->label_09 = trim(\Input::get('label_09'));
                $eqm->label_10 = trim(\Input::get('label_10'));
                $eqm->label_11 = trim(\Input::get('label_11'));
                $eqm->label_12 = trim(\Input::get('label_12'));
                $eqm->label_13 = trim(\Input::get('label_13'));
                $eqm->label_14 = trim(\Input::get('label_14'));
                $eqm->label_15 = trim(\Input::get('label_15'));
                $eqm->label_16 = trim(\Input::get('label_16'));
                $eqm->label_17 = trim(\Input::get('label_17'));
                $eqm->label_18 = trim(\Input::get('label_18'));
                $eqm->label_19 = trim(\Input::get('label_19'));
                $eqm->label_20 = trim(\Input::get('label_20'));
                $eqm->disabled = (\Input::has('disabled') ? 0 : 1);
                $eqm->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function spec_label_add($param) {
        if (!\Request::isMethod('post')) {
            $data = array(
                'category_id' => $param,
                'option' => \Equipmentspecoption::where('disabled', 0)->lists('title', 'id')
            );
            return \View::make('mod_mis.hardware.label_dialog_add', $data);
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
                try {
                    $eqm_spec_label = new \Equipmentspeclabel();
                    $eqm_spec_label->category_id = \Input::get('category_id');
                    $eqm_spec_label->title = \Input::get('title');
                    $eqm_spec_label->option_id = (\Input::has('option_id') ? \Input::get('option_id') : 0);
                    $eqm_spec_label->save();
                } catch (\Exception $exc) {
                    echo $exc->getTraceAsString();
                }

                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function spec_label_edit($param) {
        if (!\Request::isMethod('post')) {
            $eqm_spec_label = \Equipmentspeclabel::find($param);
            $data = array(
                'category_id' => $eqm_spec_label->category_id,
                'item' => $eqm_spec_label,
                'option' => \Equipmentspecoption::where('disabled', 0)->lists('title', 'id')
            );
            return \View::make('mod_mis.hardware.label_dialog_edit', $data);
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
                try {
                    $eqm_spec_label = \Equipmentspeclabel::find($param);
                    $eqm_spec_label->title = \Input::get('title');
                    $eqm_spec_label->option_id = (\Input::has('option_id') ? \Input::get('option_id') : 0);
                    $eqm_spec_label->save();
                } catch (\Exception $exc) {
                    echo $exc->getTraceAsString();
                }
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function label_delete($param) {
        try {
            \Equipmentlabel::find($param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'mis/backend/hardware/label'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function spec_label_delete($param) {
        try {
            $eqm_spec_label = \Equipmentspeclabel::find($param);
            \Equipmentspeclabel::find($param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'mis/backend/hardware/label/view/' . $eqm_spec_label->category_id
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
