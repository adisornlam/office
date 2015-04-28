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
            ),
            'analysis_count' => \OilAnalysisItem::where('disabled', 0)->count()
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
            'title' => 'รายการวิเคราะห์น้ำมัน',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่าย Oil Service' => 'oilservice',
                'รายการวิเคราะห์น้ำมัน' => '#'
            )
        );

        return \View::make('mod_oilservice.oilservice.analysis.index', $data);
    }

    public function analysis_listall() {
        $analysis_item = \DB::table('oil_analysis_item')
                ->select(array(
            'oil_analysis_item.id as id',
            'oil_analysis_item.viscosity as viscosity',
            'oil_analysis_item.kind_id as kind_id',
            'oil_analysis_item.nas as nas',
            'oil_analysis_item.colour as colour',
            'oil_analysis_item.moisture as moisture',
            'oil_analysis_item.oxidation as oxidation',
            'oil_analysis_item.nitration as nitration',
            'oil_analysis_item.tan as tan',
            'oil_analysis_item.density as density',
            'oil_analysis_item.intensity as intensity',
            'oil_analysis_item.diagnose as diagnose',
            'oil_analysis_item.solve as solve',
            'oil_analysis_item.created_at as created_at',
            'oil_analysis_item.disabled as disabled'
        ));

        if (\Input::has('viscosity')) {
            $analysis_item->where('oil_analysis_item.type_id', \Input::get('type_id'));
        }
        if (\Input::has('viscosity')) {
            $analysis_item->where('oil_analysis_item.machine_id', \Input::get('machine_id'));
        }

        if (\Input::has('viscosity')) {
            $analysis_item->where('oil_analysis_item.viscosity', \Input::get('viscosity'));
        }

        if (\Input::has('viscosity')) {
            $analysis_item->where('oil_analysis_item.kind_id', \Input::get('kind_id'));
        }

        if (\Input::has('nas')) {
            $analysis_item->where('oil_analysis_item.nas', \Input::get('nas'));
        }

        if (\Input::has('colour')) {
            $analysis_item->where('oil_analysis_item.colour', \Input::get('colour'));
        }

        if (\Input::has('moisture')) {
            $analysis_item->where('oil_analysis_item.moisture', \Input::get('moisture'));
        }

        if (\Input::has('oxidation')) {
            $analysis_item->where('oil_analysis_item.oxidation', \Input::get('oxidation'));
        }

        if (\Input::has('nitration')) {
            $analysis_item->where('oil_analysis_item.nitration', \Input::get('nitration'));
        }

        if (\Input::has('tan')) {
            $analysis_item->where('oil_analysis_item.tan', \Input::get('tan'));
        }

        if (\Input::has('density')) {
            $analysis_item->where('oil_analysis_item.density', \Input::get('density'));
        }

        if (\Input::has('intensity')) {
            $analysis_item->where('oil_analysis_item.intensity', \Input::get('intensity'));
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
                        ->add_column('nas_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 1)->where('id', $result_obj->nas)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title2 . ' (' . $oil_status_item->title . ')';
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('colour_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 3)->where('id', $result_obj->colour)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('viscosity_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 4)->where('id', $result_obj->viscosity)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title . ' (' . $result_obj->kind_id . ')';
                                ;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('tan_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 5)->where('id', $result_obj->tan)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('moisture_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 6)->where('id', $result_obj->moisture)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('oxidation_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 7)->where('id', $result_obj->oxidation)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('nitration_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 8)->where('id', $result_obj->nitration)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('density_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 9)->where('id', $result_obj->density)->first();
                            if ($oil_status_item) {
                                $str = $oil_status_item->title;
                            } else {
                                $str = NULL;
                            }
                            return $str;
                        })
                        ->add_column('intensity_text', function($result_obj) {
                            $oil_status_item = \OilStatusItem::where('group_id', 10)->where('id', $result_obj->nitration)->first();
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
