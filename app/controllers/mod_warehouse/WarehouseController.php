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
 * @author Administrator
 */
class WarehouseController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('auth', array('except' => '/login'));
    }

    public function index() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data = array(
            'title' => 'ภาพรวมฝ่ายคลังสินค้า',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายคลังสินค้า' => '#'
            )
        );
        if ($check->is('administrator')) {
            return \View::make('mod_mis.home.admin.index', $data);
        } elseif ($check->is('admin')) {
            return \View::make('mod_mis.home.admin.index', $data);
        } elseif ($check->is('warehouse')) {
            return \View::make('mod_warehouse.home.index', $data);
        } else {
            
        }
    }

    public function deadstock() {
        $data = array(
            'title' => 'รายการสินค้าคงค้าง',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายคลังสินค้า' => 'warehouse',
                'รายการสินค้าคงค้าง' => '#'
            )
        );

        return \View::make('mod_warehouse.warehouse.deadstock.index', $data);
    }

    public function analysis_listall() {
        $analysis_item = \DB::table('warehouse_deadstock_item')
                ->join('warehouse_deadstock_type', 'warehouse_deadstock_item.type_id', '=', 'warehouse_deadstock_type.id')
                ->join('warehouse_deadstock_brand', 'warehouse_deadstock_item.brand_id', '=', 'warehouse_deadstock_brand.id')
                ->select(array(
            'warehouse_deadstock_item.id as id',
            'warehouse_deadstock_type.title as type_title',
            'warehouse_deadstock_brand.code_no as brand',
            'warehouse_deadstock_item.description as description',
            'warehouse_deadstock_item.xp5 as xp5',
            'warehouse_deadstock_item.xp51_12 as xp51_12',
            'warehouse_deadstock_item.xp5a as xp5a',
            'warehouse_deadstock_item.dead1 as dead1',
            'warehouse_deadstock_item.dead2 as dead2',
            'warehouse_deadstock_item.dead3 as dead3',
            'warehouse_deadstock_item.dead4 as dead4',
            'warehouse_deadstock_item.dead5 as dead5'
        ));

        if (\Input::has('viscosity')) {
            $analysis_item->where('oil_analysis_item.type_id', \Input::get('type_id'));
        }

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;"  rel="oilservice/analysis/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="oilservice/analysis/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($analysis_item)
                        ->edit_column('id', $link)
                        ->make(true);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            $oil_status_1 = \OilStatusItem::where('group_id', 1)->where('wieht', \Input::get('viscosity'))->first();
            $oil_status_2 = \OilStatusItem::where('group_id', 2)->where('wieht', \Input::get('nas'))->first();
            $oil_status_3 = \OilStatusItem::where('group_id', 3)->where('wieht', \Input::get('colour'))->first();
            $oil_status_4 = \OilStatusItem::where('group_id', 4)->where('wieht', \Input::get('moisture'))->first();
            $oil_status_5 = \OilStatusItem::where('group_id', 5)->where('wieht', \Input::get('oxidation'))->first();
            $oil_status_6 = \OilStatusItem::where('group_id', 6)->where('wieht', \Input::get('nitration'))->first();
            $oil_status_7 = \OilStatusItem::where('group_id', 7)->where('wieht', \Input::get('tan'))->first();
            $data = array(
                'title' => 'เพิ่มรายการวิเคราะห์',
                'breadcrumbs' => array(
                    'ภาพรวมระบบ' => '',
                    'ภาพรวมฝ่าย Oil Service' => 'oilservice',
                    'รายการวิเคราะห์น้ำมัน' => 'oilservice/analysis',
                    'เพิ่มรายการวิเคราะห์' => '#'
                ),
                'viscosity_rp' => (isset($oil_status_1->title) ? $oil_status_1->title : NULL),
                'nas_rp' => (isset($oil_status_2->title) ? $oil_status_2->title : NULL),
                'colour_rp' => (isset($oil_status_3->title) ? $oil_status_3->title : NULL),
                'moisture_rp' => (isset($oil_status_4->title) ? $oil_status_4->title : NULL),
                'oxidation_rp' => (isset($oil_status_5->title) ? $oil_status_5->title : NULL),
                'nitration_rp' => (isset($oil_status_6->title) ? $oil_status_6->title : NULL),
                'tan_rp' => (isset($oil_status_7->title) ? $oil_status_7->title : NULL)
            );
            return \View::make('mod_oilservice.oilservice.analysis.add', $data);
        } else {
            $analysis_count = \DB::table('oil_analysis_item')
                    ->where('type_id', \Input::get('type_id'))
                    ->where('machine_id', \Input::get('machine_id'))
                    ->where('nas', \Input::get('nas'))
                    ->where('colour', \Input::get('colour'))
                    ->where('viscosity', \Input::get('viscosity'))
                    ->where('kind_id', \Input::get('kind_id'))
                    ->where('tan', \Input::get('tan'))
                    ->where('moisture', \Input::get('moisture'))
                    ->where('oxidation', \Input::get('oxidation'))
                    ->where('nitration', \Input::get('nitration'))
                    ->count();
            if ($analysis_count <= 0) {
                $oil_analysis_item = new \OilAnalysisItem();

                $oil_analysis_item->type_id = \Input::get('type_id');
                $oil_analysis_item->machine_id = \Input::get('machine_id');
                $oil_analysis_item->nas = \Input::get('nas');
                $oil_analysis_item->colour = \Input::get('colour');
                $oil_analysis_item->viscosity = \Input::get('viscosity');
                $oil_analysis_item->kind_id = \Input::get('kind_id');
                $oil_analysis_item->tan = \Input::get('tan');
                $oil_analysis_item->moisture = \Input::get('moisture');
                $oil_analysis_item->oxidation = \Input::get('oxidation');
                $oil_analysis_item->nitration = \Input::get('nitration');
                $oil_analysis_item->density = \Input::get('density');
                $oil_analysis_item->intensity = \Input::get('intensity');
                $oil_analysis_item->diagnose = trim(\Input::get('diagnose'));
                $oil_analysis_item->solve = trim(\Input::get('solve'));
                $oil_analysis_item->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            } else {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => 'ค่าที่กรอกนี้มีอยู่แล้ว กรุณาตรวจสอบอีกครั้ง !!!'
                            ), 400));
            }

            return \Response::json(array(
                        'error' => array(
                            'status' => TRUE,
                            'message' => NULL
                        ), 200));
        }
    }

    public function edit($id = 0) {
        if (!\Request::isMethod('post')) {
            $data = array(
                'item' => \OilAnalysisItem::find($id)
            );
            return \View::make('mod_oilservice.oilservice.analysis.edit', $data);
        } else {
            $rules = array();
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $analysis_item = \OilAnalysisItem::find($id);
                $analysis_item->diagnose = \Input::get('diagnose');
                $analysis_item->solve = \Input::get('solve');
                $analysis_item->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function analysis_delete($param) {
        try {
            \OilAnalysisItem::find($param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'oilservice/analysis'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
