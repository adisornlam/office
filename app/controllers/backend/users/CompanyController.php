<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com 
 */

namespace App\Controllers\Backend;

/**
 * Description of UsersController
 *
 * @author R-D-6
 */
class CompanyController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('auth', array('except' => 'login'));
    }

    public function index() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data = array(
            'title' => 'รายการบริษัท'
        );
        if (\Auth::check()) {
            if ($check->is('administrator')) {
                return \View::make('backend.users.admin.company.index', $data);
            } elseif ($check->is('employee')) {
                
            }
        } else {
            return \View::make('backend.users.guest.company', $data);
        }
    }

    public function listall() {
        $company = \Company::select(array(
                    'id',
                    'company_code',
                    'title',
                    'email',
                    'phone',
                    'fax',
                    'disabled',
                    'created_at',
                    'updated_at'
                ))
                ->where('deleted_at', 0);

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="users/backend/company/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="users/backend/company/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($company)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            return \View::make('backend.users.admin.company.add');
        } else {
            $rules = array(
                'title' => 'required',
                'address1' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $company = new \Company();
                $company->title = trim(\Input::get('title'));
                $company->company_code = trim(\Input::get('company_code'));
                $company->address1 = trim(\Input::get('address1'));
                $company->address2 = trim(\Input::get('address2'));
                $company->district = \Input::get('district');
                $company->amphur = \Input::get('amphur');
                $company->province = \Input::get('province');
                $company->zipcode = \Input::get('zipcode');
                $company->email = trim(\Input::get('email'));
                $company->phone = trim(\Input::get('phone'));
                $company->fax = trim(\Input::get('fax'));
                $company->disabled = (\Input::has('disabled') ? 0 : 1);
                $company->created_user = \Auth::user()->id;
                $company->save();
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
            $data = array(
                'item' => \Company::find($param),
            );
            return \View::make('backend.users.admin.company.edit', $data);
        } else {
            $rules = array(
                'title' => 'required',
                'address1' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $company = \Company::find(\Input::get('id'));
                $company->title = trim(\Input::get('title'));
                $company->company_code = trim(\Input::get('company_code'));
                $company->address1 = trim(\Input::get('address1'));
                $company->address2 = trim(\Input::get('address2'));
                $company->district = \Input::get('district');
                $company->amphur = \Input::get('amphur');
                $company->province = \Input::get('province');
                $company->zipcode = \Input::get('zipcode');
                $company->email = trim(\Input::get('email'));
                $company->phone = trim(\Input::get('phone'));
                $company->fax = trim(\Input::get('fax'));
                $company->disabled = (\Input::has('disabled') ? 0 : 1);
                $company->updated_user = \Auth::user()->id;
                $company->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function delete($param) {
        $company = \Company::find($param);
        $company->delete();
        return \Response::json(array(
                    'error' => array(
                        'status' => TRUE,
                        'message' => NULL
                    ), 200));
    }

}
