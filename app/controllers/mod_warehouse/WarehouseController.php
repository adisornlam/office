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
            ),
            'deadstock_count' => \WarehouseDeadstockItem::count(),
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

    public function deadstock_listall() {
        $deadstock_item = \DB::table('warehouse_deadstock_item')
                ->leftJoin('warehouse_type', 'warehouse_deadstock_item.type_id', '=', 'warehouse_type.code_no')
                ->leftJoin('warehouse_brand', 'warehouse_deadstock_item.brand_id', '=', 'warehouse_brand.code_no')
                ->select(array(
            'warehouse_deadstock_item.id as id',
            'warehouse_type.title as type_title',
            'warehouse_brand.title as brand',
            'warehouse_deadstock_item.code_no as code_no',
            'warehouse_deadstock_item.description as description',
            'warehouse_deadstock_item.xp5 as xp5',
            'warehouse_deadstock_item.xp51_12 as xp51_12',
            'warehouse_deadstock_item.xp5a as xp5a',
            'warehouse_deadstock_item.unit as unit',
            'warehouse_deadstock_item.dead1 as dead1',
            'warehouse_deadstock_item.dead2 as dead2',
            'warehouse_deadstock_item.dead3 as dead3',
            'warehouse_deadstock_item.dead4 as dead4',
            'warehouse_deadstock_item.dead5 as dead5',
            'warehouse_deadstock_item.disabled as disabled'
        ));
        if (\Input::has('type_id')) {
            $deadstock_item->where('warehouse_deadstock_item.type_id', \Input::get('type_id'));
        }

        if (\Input::has('brand_id')) {
            $deadstock_item->where('warehouse_deadstock_item.brand_id', \Input::get('brand_id'));
        }

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;"  rel="warehouse/deadstock/upload/photo/{{$id}}" class="link_dialog" title="เพิ่มรูปภาพ {{$code_no}}"><i class="fa fa-picture-o"></i> เพิ่มรูปภาพ</a></li>';
        //$link .= '<li><a href="javascript:;" rel="warehouse/deadstock/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($deadstock_item)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->add_column('cover', function($result_obj) {
                            $photo = \WarehouseDeadstockPhotoItem::where('deadstock_code_no', '=', $result_obj->code_no)->where('photo_cover', '=', 1)->first();
                            $str = (isset($photo->photo_resize) ? $photo->photo_resize : null);
                            return $str;
                        })
                        ->edit_column('xp5', function($result_obj) {
                            $str = ($result_obj->xp5 != '0.00' ? $result_obj->xp5 : '');
                            return $str;
                        })
                        ->edit_column('xp51_12', function($result_obj) {
                            $str = ($result_obj->xp51_12 != '0.00' ? $result_obj->xp51_12 : '');
                            return $str;
                        })
                        ->edit_column('xp5a', function($result_obj) {
                            $str = ($result_obj->xp5a != '0.00' ? $result_obj->xp5a : '');
                            return $str;
                        })
                        ->edit_column('dead1', function($result_obj) {
                            $str = ($result_obj->dead1 != '0.00' ? number_format($result_obj->dead1, 2) : '');
                            return $str;
                        })
                        ->edit_column('dead2', function($result_obj) {
                            $str = ($result_obj->dead2 != '0.00' ? number_format($result_obj->dead2, 2) : '');
                            return $str;
                        })
                        ->edit_column('dead3', function($result_obj) {
                            $str = ($result_obj->dead3 != '0.00' ? number_format($result_obj->dead3, 2) : '');
                            return $str;
                        })
                        ->edit_column('dead4', function($result_obj) {
                            $str = ($result_obj->dead4 != '0.00' ? number_format($result_obj->dead4, 2) : '');
                            return $str;
                        })
                        ->edit_column('dead5', function($result_obj) {
                            $str = ($result_obj->dead5 != '0.00' ? number_format($result_obj->dead5, 2) : '');
                            return $str;
                        })
                        ->make(true);
    }

    public function import_dialog() {
        if (!\Request::isMethod('post')) {
            return \View::make('mod_warehouse.warehouse.deadstock.import_dialog');
        } else {
            $rules = array(
                'import_date' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $destinationPath = 'uploads/warehouse/deadstock/';
                $files = \Request::file('deadstock_file');
                $extension = $files->getClientOriginalExtension();
                $newfilename = time() . '.' . $extension;
                $files->move($destinationPath, $newfilename);

                $fullpath = $destinationPath . $newfilename;
                $file = fopen($fullpath, "r");
                while (!feof($file)) {
                    $item = fgetcsv($file);
                    if ($item[0] != '') {
                        $temp_import = new \WarehouseDeadstockTempImport();
                        $temp_import->type = trim($item[0]);
                        $temp_import->brand = trim($item[1]);
                        $temp_import->code_no = trim($item[2]);
                        $temp_import->description = trim($item[3]);
                        $temp_import->xp5 = trim($item[4]);
                        $temp_import->xp51_12 = trim($item[5]);
                        $temp_import->xp5a = trim($item[6]);
                        $temp_import->unit = trim($item[7]);
                        $temp_import->price_per_unit = trim($item[8]);
                        $temp_import->total_value = trim($item[9]);
                        $temp_import->dead1 = trim($item[10]);
                        $temp_import->dead2 = trim($item[11]);
                        $temp_import->dead3 = trim($item[12]);
                        $temp_import->dead4 = trim($item[13]);
                        $temp_import->dead5 = trim($item[14]);
                        $temp_import->summary = trim($item[15]);
                        $temp_import->import_date = \Input::get('import_date');
                        $temp_import->save();
                    }
                }
                fclose($file);
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function deadstock_temp_listall() {
        $deadstock_temp_item = \DB::table('warehouse_deadstock_temp_import')
                ->select(array(
            'warehouse_deadstock_temp_import.id as id',
            'warehouse_deadstock_temp_import.type as type',
            'warehouse_deadstock_temp_import.brand as brand',
            'warehouse_deadstock_temp_import.code_no as code_no',
            'warehouse_deadstock_temp_import.description as description',
            'warehouse_deadstock_temp_import.xp5 as xp5',
            'warehouse_deadstock_temp_import.xp51_12 as xp51_12',
            'warehouse_deadstock_temp_import.xp5a as xp5a',
            'warehouse_deadstock_temp_import.unit as unit',
            'warehouse_deadstock_temp_import.price_per_unit as price_per_unit',
            'warehouse_deadstock_temp_import.total_value as total_value',
            'warehouse_deadstock_temp_import.dead1 as dead1',
            'warehouse_deadstock_temp_import.dead2 as dead2',
            'warehouse_deadstock_temp_import.dead3 as dead3',
            'warehouse_deadstock_temp_import.dead4 as dead4',
            'warehouse_deadstock_temp_import.dead5 as dead5',
            'warehouse_deadstock_temp_import.summary as summary'
        ));

        return \Datatables::of($deadstock_temp_item)
                        ->make(true);
    }

    public function deadstock_temp() {
        $data = array(
            'title' => 'รายการนำเข้าข้อมูล',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายคลังสินค้า' => 'warehouse',
                'รายการสินค้าคงค้าง' => 'warehouse/deadstock',
                'รายการนำเข้าข้อมูล' => '#'
            )
        );

        return \View::make('mod_warehouse.warehouse.deadstock.import_temp', $data);
    }

    public function import_save() {
        \DB::table('warehouse_deadstock_item')->truncate();
        \DB::statement(\DB::raw('CALL synchronize_deadstock_temp_to_item();'));
        \DB::statement(\DB::raw('CALL synchronize_deadstock_temp_to_log();'));
        \DB::table('warehouse_deadstock_temp_import')->truncate();
        return \Response::json(array(
                    'error' => array(
                        'status' => TRUE,
                        'message' => NULL
                    ), 200));
    }

    public function deadstock_report_listall() {
        
        $analysis_item = \DB::table('warehouse_deadstock_item_log')
                ->leftJoin('warehouse_type', 'warehouse_deadstock_item_log.type_id', '=', 'warehouse_type.code_no')
                ->leftJoin('warehouse_brand', 'warehouse_deadstock_item_log.brand_id', '=', 'warehouse_brand.code_no')
                ->select(array(
            'warehouse_deadstock_item_log.id as id',
            'warehouse_type.title as type_title',
            'warehouse_brand.title as brand',
            'warehouse_deadstock_item_log.code_no as code_no',
            'warehouse_deadstock_item_log.description as description',
            'warehouse_deadstock_item_log.xp5 as xp5',
            'warehouse_deadstock_item_log.xp51_12 as xp51_12',
            'warehouse_deadstock_item_log.xp5a as xp5a',
            'warehouse_deadstock_item_log.unit as unit',
            'warehouse_deadstock_item_log.dead1 as dead1',
            'warehouse_deadstock_item_log.dead2 as dead2',
            'warehouse_deadstock_item_log.dead3 as dead3',
            'warehouse_deadstock_item_log.dead4 as dead4',
            'warehouse_deadstock_item_log.dead5 as dead5',
            'warehouse_deadstock_item_log.disabled as disabled'
        ));
        
        if (\Input::has('import_date_from')) {
            $analysis_item->whereBetween('warehouse_deadstock_item_log.import_date', array(\Input::get('import_date_from'), (\Input::get('import_date_to') ? \Input::get('import_date_to') : date('Y-m-d'))));
        }

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;"  rel="warehouse/deadstock/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="warehouse/deadstock/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($analysis_item)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->add_column('cover', function($result_obj) {
                            $photo = \WarehouseDeadstockPhotoItem::where('deadstock_code_no', '=', $result_obj->code_no)->where('photo_cover', '=', 1)->first();
                            $str = (isset($photo->photo_resize) ? $photo->photo_resize : null);
                            return $str;
                        })
                        ->edit_column('xp5', function($result_obj) {
                            $str = ($result_obj->xp5 != '0.00' ? $result_obj->xp5 : '');
                            return $str;
                        })
                        ->edit_column('xp51_12', function($result_obj) {
                            $str = ($result_obj->xp51_12 != '0.00' ? $result_obj->xp51_12 : '');
                            return $str;
                        })
                        ->edit_column('xp5a', function($result_obj) {
                            $str = ($result_obj->xp5a != '0.00' ? $result_obj->xp5a : '');
                            return $str;
                        })
                        ->edit_column('dead1', function($result_obj) {
                            $str = ($result_obj->dead1 != '0.00' ? number_format($result_obj->dead1, 2) : '');
                            return $str;
                        })
                        ->edit_column('dead2', function($result_obj) {
                            $str = ($result_obj->dead2 != '0.00' ? number_format($result_obj->dead2, 2) : '');
                            return $str;
                        })
                        ->edit_column('dead3', function($result_obj) {
                            $str = ($result_obj->dead3 != '0.00' ? number_format($result_obj->dead3, 2) : '');
                            return $str;
                        })
                        ->edit_column('dead4', function($result_obj) {
                            $str = ($result_obj->dead4 != '0.00' ? number_format($result_obj->dead4, 2) : '');
                            return $str;
                        })
                        ->edit_column('dead5', function($result_obj) {
                            $str = ($result_obj->dead5 != '0.00' ? number_format($result_obj->dead5, 2) : '');
                            return $str;
                        })
                        ->make(true);
    }

    public function deadstock_report() {
        $import_date = \DB::table('warehouse_deadstock_item_log')
                ->groupBy('import_date')
                ->select(array('import_date'))
                ->lists('import_date', 'import_date');
        $data = array(
            'title' => 'ประวัติรายการ Dead Stock',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายคลังสินค้า' => 'warehouse',
                'ประวัติรายการ Dead Stock' => '#'
            ),
            'import_date_from' => $import_date,
            'import_date_to' => $import_date
        );

        return \View::make('mod_warehouse.warehouse.deadstock.report', $data);
    }

    public function upload_dialog($param) {
        if (!\Request::isMethod('post')) {
            return \View::make('mod_warehouse.warehouse.deadstock.upload_dialog', array('id' => $param));
        } else {
            $rules = array(
                'deadstock_photo1' => 'image|mimes:jpeg,png|max:512',
                'deadstock_photo2' => 'image|mimes:jpeg,png|max:512',
                'deadstock_photo3' => 'image|mimes:jpeg,png|max:512',
                'deadstock_photo4' => 'image|mimes:jpeg,png|max:512',
                'deadstock_photo5' => 'image|mimes:jpeg,png|max:512'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $photo1 = \Input::file('deadstock_photo1');
                $photo2 = \Input::file('deadstock_photo2');
                $photo3 = \Input::file('deadstock_photo3');
                $photo4 = \Input::file('deadstock_photo4');
                $photo5 = \Input::file('deadstock_photo5');

                $destinationPath = 'uploads/warehouse/deadstock/' . date('Ymd') . '/';
                $deadstock_item = \WarehouseDeadstockItem::find($param);
                if ($photo1) {
                    $up1 = $this->upload_photo($photo1, $destinationPath);
                    $photo_item1 = new \WarehouseDeadstockPhotoItem();
                    $photo_item1->deadstock_code_no = $deadstock_item->code_no;
                    $photo_item1->photo_full = $up1['full'];
                    $photo_item1->photo_resize = $up1['resize'];
                    $photo_item1->photo_cover = 1;
                    $photo_item1->save();
                }

                if ($photo2) {
                    $up2 = $this->upload_photo($photo2, $destinationPath);
                    $photo_item2 = new \WarehouseDeadstockPhotoItem();
                    $photo_item2->deadstock_code_no = $deadstock_item->code_no;
                    $photo_item2->photo_full = $up2['full'];
                    $photo_item2->photo_resize = $up2['resize'];
                    $photo_item2->save();
                }

                if ($photo3) {
                    $up3 = $this->upload_photo($photo3, $destinationPath);
                    $photo_item3 = new \WarehouseDeadstockPhotoItem();
                    $photo_item3->deadstock_code_no = $deadstock_item->code_no;
                    $photo_item3->photo_full = $up3['full'];
                    $photo_item3->photo_resize = $up3['resize'];
                    $photo_item3->save();
                }

                if ($photo4) {
                    $up4 = $this->upload_photo($photo4, $destinationPath);
                    $photo_item4 = new \WarehouseDeadstockPhotoItem();
                    $photo_item4->deadstock_code_no = $deadstock_item->code_no;
                    $photo_item4->photo_full = $up4['full'];
                    $photo_item4->photo_resize = $up4['resize'];
                    $photo_item4->save();
                }

                if ($photo5) {
                    $up5 = $this->upload_photo($photo5, $destinationPath);
                    $photo_item5 = new \WarehouseDeadstockPhotoItem();
                    $photo_item5->deadstock_code_no = $deadstock_item->code_no;
                    $photo_item5->photo_full = $up5['full'];
                    $photo_item5->photo_resize = $up5['resize'];
                    $photo_item5->save();
                }
            }
            return \Response::json(array(
                        'error' => array(
                            'status' => TRUE,
                            'message' => NULL
                        ), 200));
        }
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

    private function upload_photo($file, $path) {
        $extension = $file->getClientOriginalExtension();
        $filename = str_random(32) . '.' . $extension;
        $smallfile = 'cover_' . $filename;
        $file->move($path, $filename);
        $img = \Image::make($path . $filename);
        $img->resize(150, null)->save($path . $smallfile);
        $photo = array(
            'full' => $path . $filename,
            'resize' => $path . $smallfile
        );
        return $photo;
    }

}
