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
class MisController extends \BaseController {

    public function index() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data = array(
            'title' => 'ภาพรวมฝ่ายเทคโนโลยีสารเทศ',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => '#'
            ),
            'compouter_count' => \ComputerItem::where('disabled', '=', 0)->count(),
            'users_count' => \User::where('disabled', '=', 0)->count()
        );
        if ($check->is('administrator')) {
            return \View::make('mod_mis.home.admin.index', $data);
        } elseif ($check->is('admin')) {
            return \View::make('mod_mis.home.admin.index', $data);
        } elseif ($check->is('employee')) {
            return \View::make('mod_mis.employee.index', $data);
        } elseif ($check->is('mis')) {
            return \View::make('mod_mis.home.mis.index', $data);
        } elseif ($check->is('hr')) {
            return \View::make('mod_mis.home.hr.index', $data);
        }
    }

}
