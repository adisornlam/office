<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com
 */

namespace App\Controllers\Backend;

/**
 * Description of CategoryController
 *
 * @author Administrator
 */
class ContactController extends \BaseController {

    public function index() {
        $data = array(
            'title' => 'รายชื่อผู้ติดต่อ'
        );
        return \View::make('backend.mod_contact.admin.index', $data);
    }

    public function listall() {
        $contact = \DB::table('contact_item')
                ->leftJoin('contact_list', 'contact_item.contact_id', '=', 'contact_list.id')
                ->select('contact_item.id as id', 'contact_list.title as list_title', 'contact_list.id as list_id', 'contact_item.fullname as fullname', 'contact_item.phone as phone', 'contact_item.mobile as mobile', 'contact_item.email as email', 'contact_item.disabled as disabled');

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="contact/backend/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="contact/backend/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($contact)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->edit_column('list_title', '<a href="javascript:;" ref="contact/backend/view/{{$list_id}}" class="link_dialog">{{$list_title}}</a>')
                        ->make(true);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            $data = array(
                'contact_list' => \ContactList::lists('title', 'id')
            );
            return \View::make('backend.mod_contact.admin.add', $data);
        } else {
            $rules = array(
                'fullname' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $contact = new \ContactItem();
                $contact->contact_id = \Input::get('contact_id');
                $contact->fullname = trim(\Input::get('fullname'));
                $contact->position = trim(\Input::get('position'));
                $contact->phone = trim(\Input::get('phone'));
                $contact->mobile = trim(\Input::get('mobile'));
                $contact->email = trim(\Input::get('email'));
                $contact->remark = trim(\Input::get('remark'));
                $contact->disabled = (\Input::has('disabled') ? 0 : 1);
                $contact->save();
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
                'contact_list' => \ContactList::lists('title', 'id'),
                'item' => \ContactItem::find($param),
            );
            return \View::make('backend.mod_contact.admin.edit', $data);
        } else {
            $rules = array(
                'fullname' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $contact = \ContactItem::find($param);
                $contact->contact_id = \Input::get('contact_id');
                $contact->fullname = trim(\Input::get('fullname'));
                $contact->position = trim(\Input::get('position'));
                $contact->phone = trim(\Input::get('phone'));
                $contact->mobile = trim(\Input::get('mobile'));
                $contact->email = trim(\Input::get('email'));
                $contact->remark = trim(\Input::get('remark'));
                $contact->disabled = (\Input::has('disabled') ? 0 : 1);
                $contact->save();
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
            \ContactItem::find($param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'contact/backend'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function group() {
        $data = array(
            'title' => 'กลุ่มผู้ติดต่อ',
            'breadcrumbs' => array(
                'รายการผู้ติดต่อ' => 'contact/backend',
                'กลุ่มผู้ติดต่อ' => '#'
            )
        );
        return \View::make('backend.mod_contact.admin.group', $data);
    }

    public function group_listall() {
        $group = \ContactList::select(array('id', 'title', 'address', 'phone', 'fax', 'email', 'remark', 'disabled'));

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="contact/backend/group/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="contact/backend/group/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($group)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function group_add() {
        if (!\Request::isMethod('post')) {
            $data = array(
                'contact_type' => \ContactType::lists('title', 'id')
            );
            return \View::make('backend.mod_contact.admin.group_add', $data);
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
                $contact = new \ContactList();
                $contact->type_id = \Input::get('type_id');
                $contact->title = trim(\Input::get('title'));
                $contact->address = trim(\Input::get('address'));
                $contact->phone = trim(\Input::get('phone'));
                $contact->fax = trim(\Input::get('fax'));
                $contact->email = trim(\Input::get('email'));
                $contact->remark = trim(\Input::get('remark'));
                $contact->disabled = (\Input::has('disabled') ? 0 : 1);
                $contact->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function group_edit($param) {
        if (!\Request::isMethod('post')) {
            $data = array(
                'contact_type' => \ContactType::lists('title', 'id'),
                'item' => \ContactList::find($param),
            );
            return \View::make('backend.mod_contact.admin.group_edit', $data);
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
                $contact = \ContactList::find($param);
                $contact->type_id = \Input::get('type_id');
                $contact->title = trim(\Input::get('title'));
                $contact->address = trim(\Input::get('address'));
                $contact->phone = trim(\Input::get('phone'));
                $contact->fax = trim(\Input::get('fax'));
                $contact->email = trim(\Input::get('email'));
                $contact->remark = trim(\Input::get('remark'));
                $contact->disabled = (\Input::has('disabled') ? 0 : 1);
                $contact->save();
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE,
                                'message' => NULL
                            ), 200));
            }
        }
    }

    public function group_delete($param) {
        try {
            \ContactList::find($param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'contact/backend/group'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
