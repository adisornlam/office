<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com
 */

namespace App\Controllers\Backend;

/**
 * Description of MenuController
 *
 * @author Administrator
 */
class MenuController extends \BaseController {

    public function index() {
        $data = array(
            'title' => 'รายการเมนู'
        );
        return \View::make('backend.mod_setting.admin.menu.index', $data);
    }

    public function sub($id = 0) {
        $menu = \Menu::find($id);
        $data = array(
            'title' => 'รายการเมนู',
            'id' => $id,
            'breadcrumbs' => array(
                'รายการเมนู' => 'setting/backend/menu',
                $menu->title => '#'
            )
        );
        return \View::make('backend.mod_setting.admin.menu.sub', $data);
    }

    public function listall($id = 0) {
        $menu = \Menu::select(array('id', 'id as menu_id', 'title', 'url', 'module', 'rank', 'disabled'))
                ->where('sub_id', $id);

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="setting/backend/menu/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="setting/backend/menu/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($menu)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->edit_column('title', '<a href="{{URL::to("setting/backend/menu/sub/$menu_id")}}">{{$title}}</a>')
                        ->make(true);
    }

    public function add($id = 0) {
        if (!\Request::isMethod('post')) {
            return \View::make('backend.mod_setting.admin.menu.add');
        } else {
            $rules = array(
                'title' => 'required',
                'url' => 'required',
                'module' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $menu = new \Menu();
                $menu->sub_id = trim($id);
                $menu->title = trim(\Input::get('title'));
                $menu->url = trim(\Input::get('url'));
                $menu->module = trim(\Input::get('module'));
                $menu->rank = trim(\Input::get('rank'));
                $menu->disabled = (\Input::has('disabled') ? 0 : 1);
                $menu->save();
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
                'item' => \Menu::find($param),
                'sub_id' => \Menu::find($param)->sub_id
            );
            return \View::make('backend.mod_setting.admin.menu.edit', $data);
        } else {
            $rules = array(
                'title' => 'required',
                'url' => 'required',
                'module' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->errors()->toArray()
                            ), 400));
            } else {
                $menu = \Menu::find($param);
                $menu->title = trim(\Input::get('title'));
                $menu->url = trim(\Input::get('url'));
                $menu->module = trim(\Input::get('module'));
                $menu->rank = trim(\Input::get('rank'));
                $menu->disabled = (\Input::has('disabled') ? 0 : 1);
                $menu->save();
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
            $menu = \Menu::find($param);
            \Menu::find($param)->delete();                   
            \Menurole::where('menu_id', $param)->delete();
            return \Response::json(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'ลบรายการสำเร็จ',
                            'redirect' => 'setting/backend/menu' . ($menu->sub_id > 0 ? '/sub/' . $menu->sub_id : '')
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
