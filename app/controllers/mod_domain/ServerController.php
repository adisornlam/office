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
class ServerController extends \BaseController {

    public function index() {
        $data = array(
            'title' => 'Server ทั้งหมด',
            'breadcrumbs' => array(
                'รายการ Domain' => 'domain/backend',
                'รายการ Server' => '#'
            ),
        );
        return \View::make('mod_domain.server.index', $data);
    }

    public function listall() {
        $domain = \DB::table('server_item')
                ->leftJoin('contact_item', 'server_item.contact_id', '=', 'contact_item.id')
                ->select('server_item.id as id', 'server_item.title as server_title', 'server_item.expire_date as server_expire', 'contact_item.id as contact_id', 'contact_item.fullname as contact_name', 'server_item.disabled as disabled');

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/domain/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/domain/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($domain)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->edit_column('server_expire', '{{ \Carbon::createFromTimeStamp(strtotime($server_expire))->diffInDays() }}')
                        ->add_column('server_expire_date', '{{$server_expire}}')
                        ->edit_column('contact_name', '<a href="javascript:;" ref="contact/view/{{$contact_id}}" class="link_dialog">{{$contact_name}}</a>')
                        ->make(true);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            $data = array(
                'company' => \Company::lists('title', 'id'),
                'contact' => \ContactItem::lists('fullname', 'id')
            );
            return \View::make('mod_domain.server.add', $data);
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
                $server = new \ServerItem();
                $server->contact_id = \Input::get('contact_id');
                $server->title = trim(\Input::get('title'));
                $server->register_date = trim(\Input::get('register_date'));
                $server->expire_date = trim(\Input::get('expire_date'));
                $server->cost = trim(\Input::get('cost'));
                $server->remark = trim(\Input::get('remark'));
                $server->disabled = (\Input::has('disabled') ? 0 : 1);
                $server->created_user = \Auth::user()->id;
                $server->save();
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
                'contact' => \ContactItem::lists('fullname', 'id')
            );
            return \View::make('mod_domain.server.edit', $data);
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
                $server = \ServerItem::find($param);
                $server->contact_id = \Input::get('contact_id');
                $server->title = trim(\Input::get('title'));
                $server->register_date = trim(\Input::get('register_date'));
                $server->expire_date = trim(\Input::get('expire_date'));
                $server->cost = trim(\Input::get('cost'));
                $server->remark = trim(\Input::get('remark'));
                $server->disabled = (\Input::has('disabled') ? 0 : 1);
                $server->updated_user = \Auth::user()->id;
                $server->save();
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
