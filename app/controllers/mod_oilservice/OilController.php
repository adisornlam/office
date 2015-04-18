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
class OilController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('auth', array('except' => '/login'));
    }

    public function index() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data = array(
            'title' => 'ภาพรวมฝ่าย Oil Service',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่าย Oil Service' => '#'
            )
        );
        if ($check->is('administrator')) {
            return \View::make('mod_mis.home.admin.index', $data);
        } elseif ($check->is('admin')) {
            return \View::make('mod_mis.home.admin.index', $data);
        } elseif ($check->is('employee')) {
            return \View::make('mod_mis.home.employee.index', $data);
        } elseif ($check->is('mis')) {
            return \View::make('mod_mis.home.mis.index', $data);
        } elseif ($check->is('hr')) {
            return \View::make('mod_mis.home.hr.index', $data);
        } elseif ($check->is('oil_service')) {
            return \View::make('mod_oilservice.home.index', $data);
        }
    }

    public function analysis() {
        $data = array(
            'title' => 'รายการวิเคราะห์น้ำมันไฮดรอลิค',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่าย Oil Service' => 'oilservice',
                'รายการวิเคราะห์น้ำมันไฮดรอลิค' => '#'
            )
        );

        return \View::make('mod_oilservice.oilservice.analysis.index', $data);
    }

    public function analysis_listall() {
        $computer_item = \DB::table('oil_analysis_item')
                ->select(array(
            'oil_analysis_item.id as id',
            'oil_analysis_item.viscosity as viscosity',
            'oil_analysis_item.nas as nas',
            'oil_analysis_item.colour as colour',
            'oil_analysis_item.moisture as moisture',
            'oil_analysis_item.oxidation as oxidation',
            'oil_analysis_item.nitration as nitration',
            'oil_analysis_item.tan as tan',
            'oil_analysis_item.created_at as created_at',
            'oil_analysis_item.disabled as disabled'
        ));

//        $link = '<div class="dropdown">';
//        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
//        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
//        $link .= '<li><a href="{{\URL::to("oilservice/analysis/edit/$id")}}" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
//        $link .= '<li><a href="javascript:;" rel="oilservice/analysis/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
//        $link .= '</ul>';
//        $link .= '</div>';

        return \Datatables::of($computer_item)
                        //->edit_column('id', $link)
                        ->add_column('viscosity_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 1)->where('wieht', $result_obj->viscosity)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('nas_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 2)->where('wieht', $result_obj->nas)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('colour_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 3)->where('wieht', $result_obj->colour)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('moisture_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 4)->where('wieht', $result_obj->moisture)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('oxidation_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 5)->where('wieht', $result_obj->oxidation)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('nitration_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 6)->where('wieht', $result_obj->nitration)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('tan_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 7)->where('wieht', $result_obj->tan)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function add() {
        if (\Request::isMethod('post')) {
            $oil_status_1 = \OilStatusItem::where('group_id', 1)->where('wieht', \Input::get('viscosity'))->first();
            $oil_status_2 = \OilStatusItem::where('group_id', 2)->where('wieht', \Input::get('nas'))->first();
            $oil_status_3 = \OilStatusItem::where('group_id', 3)->where('wieht', \Input::get('colour'))->first();
            $oil_status_4 = \OilStatusItem::where('group_id', 4)->where('wieht', \Input::get('moisture'))->first();
            $oil_status_5 = \OilStatusItem::where('group_id', 5)->where('wieht', \Input::get('oxidation'))->first();
            $oil_status_6 = \OilStatusItem::where('group_id', 6)->where('wieht', \Input::get('nitration'))->first();
            $oil_status_7 = \OilStatusItem::where('group_id', 7)->where('wieht', \Input::get('tan'))->first();
        } else {
            
        }
        $data = array(
            'title' => 'เพิ่มรายการวิเคราะห์',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่าย Oil Service' => 'oilservice',
                'รายการวิเคราะห์น้ำมันไฮดรอลิค' => 'oilservice/analysis',
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
    }

    public function analysis_save() {
        $oil_analysis_item = new \OilAnalysisItem();
        $oil_analysis_item->viscosity = \Input::get('viscosity');
        $oil_analysis_item->nas = \Input::get('nas');
        $oil_analysis_item->colour = \Input::get('colour');
        $oil_analysis_item->moisture = \Input::get('moisture');
        $oil_analysis_item->oxidation = \Input::get('oxidation');
        $oil_analysis_item->nitration = \Input::get('nitration');
        $oil_analysis_item->tan = \Input::get('tan');
        $oil_analysis_item->diagnose = trim(\Input::get('diagnose'));
        $oil_analysis_item->solve = trim(\Input::get('solve'));
        $oil_analysis_item->save();
        return \Response::json(array(
                    'error' => array(
                        'status' => TRUE,
                        'message' => NULL
                    ), 200));
    }

}
