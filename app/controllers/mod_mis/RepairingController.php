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

    public function __construct() {
        $this->beforeFilter('auth', array('except' => '/login'));
    }

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
        } else {
            return \View::make('mod_mis.repairing.shared.index', $data);
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
            'repairing_item.desc as title',
            'repairing_group.title as group_title',
            'repairing_item.disabled as disabled',
            'repairing_item.status as status',
            'repairing_item.receive_user as receive_user',
            'repairing_item.created_user as created_user',
            'repairing_item.rating as rating',
            'repairing_item.created_at as created_at'
        ));
        $repairing->orderBy('repairing_item.id', 'desc');

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
                            $str = '<a href="' . \URL::to('mis/repairing/view/' . $result_obj->item_id . '') . '" title="ดูรายการแจ้งซ่อม">' . \Str::limit($result_obj->title, 50) . '</a>';
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
                        ->edit_column('status', function($result_obj) {
                            if ($result_obj->status == 0) {
                                $str = '<span class="label label-warning">รอรับเรื่อง</span>';
                            } elseif ($result_obj->status == 1) {
                                $str = '<span class="label label-info">กำลังดำเนินการ</span>';
                            } elseif ($result_obj->status == 2) {
                                $str = '<span class="label label-success">อยู่ระหว่างส่งงาน</span>';
                            } elseif ($result_obj->status == 3) {
                                $str = '<span class="label label-success">ดำเนินการเรียบร้อย</span>';
                            }
                            return $str;
                        })
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
            } else {
                return \View::make('mod_mis.repairing.shared.add', $data);
            }
        } else {
            $rules = array(
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
                $repairing->group_id = \Input::get('group_id');
                $repairing->desc = \Input::get('desc');
                $repairing->created_user = (\Input::get('user_id') ? \Input::get('user_id') : \Auth::user()->id);
                if (\Input::get('created_at')) {
                    $repairing->created_at = \Input::get('created_at') . ' ' . date('H:i:s');
                }
                $repairing->save();
                $repairing_id = $repairing->id;

                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL,
                                'repairing_id' => $repairing_id
                            ), 200));
            }
        }
    }

    public function view($param) {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $item = \RepairingItem::find($param);
        if ($item->group_id == 1) {

            if (\DB::table('computer_item')
                            ->join('computer_user', 'computer_item.id', '=', 'computer_user.computer_id')
                            ->where('computer_user.user_id', $item->created_user)
                            ->count() > 0) {
                $group_id = \DB::table('computer_item')
                        ->join('computer_user', 'computer_item.id', '=', 'computer_user.computer_id')
                        ->where('computer_user.user_id', $item->created_user)
                        ->select(array(
                            'computer_item.id as id',
                            \DB::raw('CONCAT(computer_item.serial_code," -- ",computer_item.title) as title')
                        ))
                        ->lists('title', 'id');
            } else {
                $group_id = \DB::table('computer_item')
                        ->where('computer_item.disabled', 0)
                        ->where('computer_item.type_id', 1)
                        ->select(array(
                            'computer_item.id as id',
                            \DB::raw('CONCAT(computer_item.serial_code," -- ",computer_item.title) as title')
                        ))
                        ->lists('title', 'id');
            }
        } elseif ($item->group_id == 2) {
            $group_id = \DB::table('computer_item')
                    ->where('computer_item.disabled', 0)
                    ->where('computer_item.type_id', 2)
                    ->select(array(
                        'computer_item.id as id',
                        \DB::raw('CONCAT(computer_item.serial_code," -- ",computer_item.title) as title')
                    ))
                    ->lists('title', 'id');
        } elseif ($item->group_id == 3) {
            $group_id = \DB::table('hsware_item')
                    ->where('disabled', 0)
                    ->where('group_id', 24)
                    ->select(array(
                        'id',
                        'serial_code as title'
                    ))
                    ->lists('title', 'id');
        } elseif ($item->group_id == 4) {
            $group_id = \DB::table('hsware_item')
                    ->where('disabled', 0)
                    ->where('group_id', 14)
                    ->select(array(
                        'id',
                        'serial_code as title'
                    ))
                    ->lists('title', 'id');
        } elseif ($item->group_id == 5) {
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
            'title' => 'รายการแจ้งซ่อม ' . \Str::limit($item->desc, 50),
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'รายการแจ้งซ่อมอุปกรณ์' => 'mis/repairing',
                'รายการแจ้งซ่อม ' . $item->title => '#'
            ),
            'item' => $item,
            'group' => \RepairingGroup::find($item->group_id),
            'user' => \User::find($item->created_user),
            'receive_user' => \User::find($item->receive_user),
            'publem' => \DB::table('repairing_publem')->where('group_id', $item->group_id)->lists('title', 'id'),
            'computer' => $group_id
        );
        if ($check->is('administrator')) {
            return \View::make('mod_mis.repairing.admin.view', $data);
        } elseif ($check->is('mis')) {
            return \View::make('mod_mis.repairing.mis.view', $data);
        } elseif ($check->is('employee')) {
            return \View::make('mod_mis.repairing.employee.view', $data);
        } else {
            return \View::make('mod_mis.repairing.shared.view', $data);
        }
    }

    public function receive($param) {
        $repairing_item = \RepairingItem::find($param);
        $repairing_item->status = 1;
        $repairing_item->receive_user = \Auth::user()->id;
        $repairing_item->receive_at = date('Y-m-d H:i:s');
        $repairing_item->save();
        return \Response::json(array(
                    'error' => array(
                        'status' => TRUE,
                        'message' => NULL
                    ), 200));
    }

    public function send_repairing($param) {
        $rules = array(
            'desc2' => 'required',
            'status' => 'required'
        );
        $validator = \Validator::make(\Input::all(), $rules);
        if ($validator->fails()) {
            return \Response::json(array(
                        'error' => array(
                            'status' => FALSE,
                            'message' => $validator->errors()->toArray()
                        ), 400));
        } else {

            $repairing_item = \RepairingItem::find($param);
            $repairing_item->publem_id = \Input::get('publem_id');
            $repairing_item->type_id = \Input::get('type_id');
            $repairing_item->desc2 = trim(\Input::get('desc2'));
            $repairing_item->status_success = \Input::get('status');
            $repairing_item->remark = trim(\Input::get('remark'));
            $repairing_item->status = 2;
            $repairing_item->success_at = \Input::get('success_at') . ' ' . date('H:i:s');
            $repairing_item->save();

            if (\Input::get('type_id') == 2) {
                $reparing_publem = \RepairingPublem::find(\Input::get('publem_id'));
                $hsware_item = \DB::table('hsware_item')
                        ->join('computer_hsware', 'hsware_item.id', '=', 'computer_hsware.hsware_id')
                        ->where('computer_hsware.computer_id', \Input::get('computer_id'))
                        ->where('hsware_item.group_id', $reparing_publem->group_ref_id)
                        ->select(array(
                            'computer_item.id as id',
                            \DB::raw('CONCAT(computer_item.serial_code," -- ",computer_item.title) as title')
                        ))
                        ->lists('title', 'id');
            }
            return \Response::json(array(
                        'error' => array(
                            'status' => TRUE,
                            'message' => NULL
                        ), 200));
        }
    }

    public function update_rating($param) {
        $repairing_item = \RepairingItem::find($param);
        $repairing_item->rating = \Input::get('val');
        $repairing_item->status = 3;
        $repairing_item->rating_at = date('Y-m-d H:i:s');
        $repairing_item->save();
        return \Response::json(array(
                    'error' => array(
                        'status' => TRUE,
                        'message' => NULL
                    ), 200));
    }

    public function delete($param) {
        try {
            \RepairingItem::find($param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'mis/repairing'
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
                ->leftJoin('repairing_publem', 'ma_item.publem_id', '=', 'repairing_publem.id')
                ->leftJoin('company', 'ma_item.company_id', '=', 'company.id');
        if (\Input::has('group_id')) {
            $repairing->where('ma_item.type_id', \Input::get('type_id'));
        }
        $repairing->select(array(
            'ma_item.id as id',
            'ma_item.id as item_id',
            'ma_item.group_id as group_id',
            'repairing_publem.title as title',
            'computer_item.serial_code as serial_code',
            'computer_item.title as computer',
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
                        ->edit_column('computer', function($result_obj) {
                            if ($result_obj->group_id == 1) {
                                $str = $result_obj->computer;
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
                        ->where('computer_item.company_id', \Input::get('company_id'))
                        ->select(array(
                            'computer_item.id as id',
                            \DB::raw('CONCAT(computer_item.serial_code," -- ",computer_item.title) as title')
                        ))
                        ->lists('title', 'id');
            } elseif (\Input::get('group_id') == 2) {
                $group_id = \DB::table('computer_item')
                        ->where('computer_item.disabled', 0)
                        ->where('computer_item.type_id', 2)
                        ->where('computer_item.company_id', \Input::get('company_id'))
                        ->select(array(
                            'computer_item.id as id',
                            \DB::raw('CONCAT(computer_item.serial_code," -- ",computer_item.title) as title')
                        ))
                        ->lists('title', 'id');
            } elseif (\Input::get('group_id') == 3) {
                $group_id = \DB::table('hsware_item')
                        ->where('hsware_item.company_id', \Input::get('company_id'))
                        ->where('disabled', 0)
                        ->where('group_id', 24)
                        ->select(array(
                            'id',
                            'serial_code as title'
                        ))
                        ->lists('title', 'id');
            } elseif (\Input::get('group_id') == 4) {
                $group_id = \DB::table('hsware_item')
                        ->where('hsware_item.company_id', \Input::get('company_id'))
                        ->where('disabled', 0)
                        ->where('group_id', 14)
                        ->select(array(
                            'id',
                            'serial_code as title'
                        ))
                        ->lists('title', 'id');
            } elseif (\Input::get('group_id') == 5) {
                $group_id = \DB::table('hsware_item')
                        ->where('hsware_item.company_id', \Input::get('company_id'))
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
                'computer' => $group_id,
                'publem' => \DB::table('repairing_publem')->where('group_id', \Input::get('group_id'))->lists('title', 'id'),
            );
            if ($check->is('administrator')) {
                return \View::make('mod_mis.admin.ma_add', $data);
            } elseif ($check->is('mis')) {
                return \View::make('mod_mis.repairing.mis.ma_add', $data);
            }
        } else {
            $rules = array(
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
                $ma_item->publem_id = \Input::get('publem_id');
                $ma_item->type_id = \Input::get('type_id');
                $ma_item->software_id = \Input::get('software_id');
                $ma_item->license_group_id = \Input::get('license_group_id');
                $ma_item->license_id = \Input::get('license_id');
                $ma_item->serial_no = 0;
                $ma_item->title = trim(\Input::get('title'));
                $ma_item->desc = \Input::get('desc');
                $ma_item->cost = trim(\Input::get('cost'));
                $ma_item->warranty = trim(\Input::get('warranty'));
                $ma_item->status = \Input::get('status');
                $ma_item->disabled = 0;
                $ma_item->created_user = \Auth::user()->id;
                $ma_item->created_at = \Input::get('created_at') . ' ' . date('H:i:s');
                $ma_item->save();

                if (\Input::get('license_id')) {
                    if (\Input::get('license_group_id') == 1) {
                        $license_item = \LicenseItem::find(\Input::get('license_id'));
                        $license_item->status = 1;
                        $license_item->save();
                    }
                    $sl = new \SoftwareLicenser();
                    $sl->computer_id = (\Input::get('group_id') <= 2 ? \Input::get('computer_id') : 0);
                    $sl->software_id = \Input::get('software_id');
                    $sl->license_id = \Input::get('license_id');
                    $sl->sbit = \Input::get('sbit');
                    $sl->save();
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
