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
class CategoryController extends \BaseController {

    public function index() {
        $data = array(
            'title' => 'หมวดหมู่อุปกรณ์',
            'breadcrumbs' => array(
                'รายการคอมพิวเตอร์/อุปกรณ์' => 'mis/backend',
                'หมวดหมู่อุปกรณ์' => '#'
            )
        );
        return \View::make('mod_mis.hardware.category', $data);
    }

    public function listall() {
        $category = \Categories::select(array(
                    'Categories.id as id',
                    'Categories.title as title',
                    'Categories.description as description',
                    'Categories.disabled as disabled'
                ))
                ->join('category_hierarchy', 'Categories.id', '=', 'category_hierarchy.category_id')
                ->where('category_hierarchy.category_parent_id', '=', 0);

        $link = '<div class="dropdown">';
        $link .= '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="fa fa-pencil-square-o"></span ></a>';
        $link .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        $link .= '<li><a href="javascript:;" rel="mis/backend/hardware/category/edit/{{$id}}" class="link_dialog" title="แก้ไขรายการ"><i class="fa fa-pencil-square-o"></i> แก้ไขรายการ</a></li>';
        $link .= '<li><a href="javascript:;" rel="mis/backend/hardware/category/delete/{{$id}}" class="link_dialog delete" title="ลบรายการ"><i class="fa fa-trash"></i> ลบรายการ</a></li>';
        $link .= '</ul>';
        $link .= '</div>';

        return \Datatables::of($category)
                        ->edit_column('id', $link)
                        ->edit_column('disabled', '@if($disabled==0) <span class="label label-success">Active</span> @else <span class="label label-danger">Inactive</span> @endif')
                        ->make(true);
    }

    public function add() {
        if (!\Request::isMethod('post')) {
            return \View::make('mod_mis.hardware.category_add');
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
                $category = new \Categories();
                $category->title = trim(\Input::get('title'));
                $category->type = trim(\Input::get('type'));
                $category->description = trim(\Input::get('description'));
                $category->disabled = (\Input::has('disabled') ? 0 : 1);
                $category->save();
                $cat_id = $category->id;

                $cat_hichy = new \Categoryhierarchy();
                $cat_hichy->category_id = $cat_id;
                $cat_hichy->category_parent_id = 0;
                $cat_hichy->save();
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
                'item' => \Categories::find($param),
            );
            return \View::make('mod_mis.hardware.category_edit', $data);
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
                $category = \Categories::find(\Input::get('id'));
                $category->title = trim(\Input::get('title'));
                $category->description = trim(\Input::get('description'));
                $category->disabled = (\Input::has('disabled') ? 0 : 1);
                $category->save();
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
                            'redirect' => 'mis/backend/hardware/category'
                        ), 200));
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
