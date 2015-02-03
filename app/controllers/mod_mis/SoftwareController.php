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
            'title' => 'รายการโปรแกรม/ซอฟต์แวร์'
        );
        return \View::make('mod_mis.software.index', $data);
    }

    public function listall() {
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
                ->where('categories.type', '=', 'equipment_software');

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="' . \URL::to('mis/backend/software/edit') . '/{{$id}}" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/backend/software/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($equipment)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            $category = \DB::table('categories')
                    ->select('categories.id as id', 'categories.title as title')
                    ->join('category_hierarchy', 'categories.id', '=', 'category_hierarchy.category_id')
                    ->where('category_hierarchy.category_parent_id', '=', 0)
                    ->where('categories.type', '=', 'equipment_software')
                    ->lists('title', 'id');
            $data = array(
                'title' => 'เพิ่มโปรแกรม/ซอฟต์แวร์',
                'breadcrumbs' => array(
                    'รายการโปรแกรม/ซอฟต์แวร์' => 'mis/backend/software',
                    'เพิ่มโปรแกรม/ซอฟต์แวร์' => '#'
                ),
                'category' => $category,
                'company' => \Company::lists('title', 'id'),
                'result' => \Equipmentspeclabel::where('category_id',6)->get()
            );
            return \View::make('mod_mis.software.equipment_add', $data);
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
                $eqm = new \Equipment();
                $eqm->category_id = \Input::get('category_id');
                $eqm->company_id = \Input::get('company_id');
                $eqm->equipment_code = trim(\Input::get('equipment_code'));
                $eqm->title = trim(\Input::get('title'));
                $eqm->spec_value_01 = (\Input::has('spec_value_01') ? trim(\Input::get('spec_value_01')) : NULL );
                $eqm->spec_value_02 = (\Input::has('spec_value_02') ? trim(\Input::get('spec_value_02')) : NULL );
                $eqm->spec_value_03 = (\Input::has('spec_value_03') ? trim(\Input::get('spec_value_03')) : NULL );
                $eqm->spec_value_04 = (\Input::has('spec_value_04') ? trim(\Input::get('spec_value_04')) : NULL );
                $eqm->spec_value_05 = (\Input::has('spec_value_05') ? trim(\Input::get('spec_value_05')) : NULL );
                $eqm->spec_value_06 = (\Input::has('spec_value_06') ? trim(\Input::get('spec_value_06')) : NULL );
                $eqm->spec_value_07 = (\Input::has('spec_value_07') ? trim(\Input::get('spec_value_07')) : NULL );
                $eqm->spec_value_08 = (\Input::has('spec_value_08') ? trim(\Input::get('spec_value_08')) : NULL );
                $eqm->spec_value_09 = (\Input::has('spec_value_09') ? trim(\Input::get('spec_value_09')) : NULL );
                $eqm->spec_value_10 = (\Input::has('spec_value_10') ? trim(\Input::get('spec_value_10')) : NULL );
                $eqm->spec_value_11 = (\Input::has('spec_value_11') ? trim(\Input::get('spec_value_11')) : NULL );
                $eqm->spec_value_12 = (\Input::has('spec_value_12') ? trim(\Input::get('spec_value_12')) : NULL );
                $eqm->spec_value_13 = (\Input::has('spec_value_13') ? trim(\Input::get('spec_value_13')) : NULL );
                $eqm->spec_value_14 = (\Input::has('spec_value_14') ? trim(\Input::get('spec_value_14')) : NULL );
                $eqm->spec_value_15 = (\Input::has('spec_value_15') ? trim(\Input::get('spec_value_15')) : NULL );
                $eqm->spec_value_16 = (\Input::has('spec_value_16') ? trim(\Input::get('spec_value_16')) : NULL );
                $eqm->spec_value_17 = (\Input::has('spec_value_17') ? trim(\Input::get('spec_value_17')) : NULL );
                $eqm->spec_value_18 = (\Input::has('spec_value_18') ? trim(\Input::get('spec_value_18')) : NULL );
                $eqm->spec_value_19 = (\Input::has('spec_value_19') ? trim(\Input::get('spec_value_19')) : NULL );
                $eqm->spec_value_20 = (\Input::has('spec_value_20') ? trim(\Input::get('spec_value_20')) : NULL );
                $eqm->description = trim(\Input::get('description'));
                $eqm->register_date = trim(\Input::get('register_date'));
                $eqm->disabled = (\Input::has('disabled') ? 0 : 1);
                $eqm->created_user = \Auth::user()->id;
                $eqm->save();
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
            $category = \DB::table('categories')
                    ->select('categories.id as id', 'categories.title as title')
                    ->join('category_hierarchy', 'categories.id', '=', 'category_hierarchy.category_id')
                    ->where('category_hierarchy.category_parent_id', '=', 0)
                    ->where('categories.type', '=', 'equipment_software')
                    ->lists('title', 'id');
            $label = \Equipmentlabel::where('category_id', 6)->where('disabled', 0)->first();
            $spec_value = \Equipment::find($param);
            $item = \Equipment::find($param);
            $data = array(
                'title' => 'เพิ่มโปรแกรม/ซอฟต์แวร์',
                'breadcrumbs' => array(
                    'รายการโปรแกรม/ซอฟต์แวร์' => 'mis/backend/software',
                    'แก้ไขโปรแกรม/ซอฟต์แวร์' => '#',
                    $item->title => '#'
                ),
                'category' => $category,
                'company' => \Company::lists('title', 'id'),
                'spec_label' => $label->toArray(),
                'spec_value' => $spec_value->toArray(),
                'item' => $item
            );
            return \View::make('mod_mis.software.equipment_edit', $data);
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
                $eqm = \Equipment::find(\Input::get('id'));
                $eqm->category_id = \Input::get('category_id');
                $eqm->company_id = \Input::get('company_id');
                $eqm->equipment_code = trim(\Input::get('equipment_code'));
                $eqm->title = trim(\Input::get('title'));
                $eqm->spec_value_01 = (\Input::has('spec_value_01') ? trim(\Input::get('spec_value_01')) : NULL );
                $eqm->spec_value_02 = (\Input::has('spec_value_02') ? trim(\Input::get('spec_value_02')) : NULL );
                $eqm->spec_value_03 = (\Input::has('spec_value_03') ? trim(\Input::get('spec_value_03')) : NULL );
                $eqm->spec_value_04 = (\Input::has('spec_value_04') ? trim(\Input::get('spec_value_04')) : NULL );
                $eqm->spec_value_05 = (\Input::has('spec_value_05') ? trim(\Input::get('spec_value_05')) : NULL );
                $eqm->spec_value_06 = (\Input::has('spec_value_06') ? trim(\Input::get('spec_value_06')) : NULL );
                $eqm->spec_value_07 = (\Input::has('spec_value_07') ? trim(\Input::get('spec_value_07')) : NULL );
                $eqm->spec_value_08 = (\Input::has('spec_value_08') ? trim(\Input::get('spec_value_08')) : NULL );
                $eqm->spec_value_09 = (\Input::has('spec_value_09') ? trim(\Input::get('spec_value_09')) : NULL );
                $eqm->spec_value_10 = (\Input::has('spec_value_10') ? trim(\Input::get('spec_value_10')) : NULL );
                $eqm->spec_value_11 = (\Input::has('spec_value_11') ? trim(\Input::get('spec_value_11')) : NULL );
                $eqm->spec_value_12 = (\Input::has('spec_value_12') ? trim(\Input::get('spec_value_12')) : NULL );
                $eqm->spec_value_13 = (\Input::has('spec_value_13') ? trim(\Input::get('spec_value_13')) : NULL );
                $eqm->spec_value_14 = (\Input::has('spec_value_14') ? trim(\Input::get('spec_value_14')) : NULL );
                $eqm->spec_value_15 = (\Input::has('spec_value_15') ? trim(\Input::get('spec_value_15')) : NULL );
                $eqm->spec_value_16 = (\Input::has('spec_value_16') ? trim(\Input::get('spec_value_16')) : NULL );
                $eqm->spec_value_17 = (\Input::has('spec_value_17') ? trim(\Input::get('spec_value_17')) : NULL );
                $eqm->spec_value_18 = (\Input::has('spec_value_18') ? trim(\Input::get('spec_value_18')) : NULL );
                $eqm->spec_value_19 = (\Input::has('spec_value_19') ? trim(\Input::get('spec_value_19')) : NULL );
                $eqm->spec_value_20 = (\Input::has('spec_value_20') ? trim(\Input::get('spec_value_20')) : NULL );
                $eqm->description = trim(\Input::get('description'));
                $eqm->register_date = trim(\Input::get('register_date'));
                $eqm->disabled = (\Input::has('disabled') ? 0 : 1);
                $eqm->updated_user = \Auth::user()->id;
                $eqm->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

}
