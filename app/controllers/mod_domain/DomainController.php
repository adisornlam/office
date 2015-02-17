<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com
 */

namespace App\Controllers;

/**
 * Description of CategoryController
 *
 * @author Administrator
 */
class DomainController extends \BaseController {

    public function index() {
        $data = array(
            'title' => 'Domain ทั้งหมด'
        );
        return \View::make('mod_domain.domain.index', $data);
    }

    public function listall() {
        $domain = \DB::table('domain_item')
                ->leftJoin('domain_server', 'domain_item.id', '=', 'domain_server.domain_id')
                ->leftJoin('server_item', 'domain_server.server_id', '=', 'server_item.id')
                ->leftJoin('contact_item', 'domain_item.contact_id', '=', 'contact_item.id')
                ->leftJoin('company', 'domain_item.company_id', '=', 'company.id')
                ->select('domain_item.id as id', 'company.title as company_title', 'domain_item.title as domain_title', 'server_item.title as server_title', 'domain_item.expire_date as domain_expire', 'contact_item.id as contact_id', 'contact_item.fullname as contact_name', 'domain_item.disabled as disabled');

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="domain/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="domain/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($domain)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->edit_column('domain_expire', '{{ \Carbon::createFromTimeStamp(strtotime($domain_expire))->diffInDays() }}')
                        ->add_column('domain_expire_date', '{{$domain_expire}}')
                        ->edit_column('contact_name', '<a href="javascript:;" ref="contact/view/{{$contact_id}}" class="link_dialog">{{$contact_name}}</a>')
                        ->make(true);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            $data = array(
                'company' => \Company::lists('title', 'id'),
                'server' => \ServerItem::lists('title', 'id'),
                'contact' => \ContactItem::lists('fullname', 'id')
            );
            return \View::make('mod_domain.domain.add', $data);
        } else {
            $rules = array(
                'title' => 'required',
                'expire_date' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $domain = new \DomainItem();
                $domain->contact_id = \Input::get('contact_id');
                $domain->company_id = \Input::get('company_id');
                $domain->title = trim(\Input::get('title'));
                $domain->register_date = trim(\Input::get('register_date'));
                $domain->expire_date = trim(\Input::get('expire_date'));
                $domain->cost = trim(\Input::get('cost'));
                $domain->remark = trim(\Input::get('remark'));
                $domain->disabled = (\Input::has('disabled') ? 0 : 1);
                $domain->created_user = \Auth::user()->id;
                $domain->save();
                if (\Input::get('server_id') > 0) {
                    $domain->server()->sync(array(\Input::get('server_id')));
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
            $domain = \DomainItem::find($param);
            $data = array(
                'item' => $domain,
                'server_id' => $domain->server,
                'company' => \Company::lists('title', 'id'),
                'server' => \ServerItem::lists('title', 'id'),
                'contact' => \ContactItem::lists('fullname', 'id')
            );
            return \View::make('mod_domain.domain.edit', $data);
        } else {
            $rules = array(
                'title' => 'required',
                'expire_date' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $domain = \DomainItem::find($param);
                $domain->contact_id = \Input::get('contact_id');
                $domain->company_id = \Input::get('company_id');
                $domain->title = trim(\Input::get('title'));
                $domain->register_date = trim(\Input::get('register_date'));
                $domain->expire_date = trim(\Input::get('expire_date'));
                $domain->cost = trim(\Input::get('cost'));
                $domain->remark = trim(\Input::get('remark'));
                $domain->disabled = (\Input::has('disabled') ? 0 : 1);
                $domain->updated_user = \Auth::user()->id;
                $domain->save();
                if (\Input::get('server_id') > 0) {
                    $domain->server()->sync(array(\Input::get('server_id')));
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
            \Categories::find($param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'mis/hardware/category'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
