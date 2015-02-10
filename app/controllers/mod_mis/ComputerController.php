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
 * @author ComputerController
 */
class ComputerController extends \BaseController {

    public function index() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data = array(
            'title' => 'ระเบียนคอมพิวเตอร์',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => '',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis',
                'ระเบียนคอมพิวเตอร์' => '#'
            )
        );

        if ($check->is('administrator')) {
            return \View::make('mod_mis.computer.admin.index', $data);
        } elseif ($check->is('admin')) {
            return \View::make('mod_mis.admin.index', $data);
        } elseif ($check->is('employee')) {
            return \View::make('mod_mis.employee.index', $data);
        } elseif ($check->is('mis')) {
            return \View::make('mod_mis.computer.mis.index', $data);
        } elseif ($check->is('hr')) {
            return \View::make('mod_mis.home.hr.index', $data);
        }
    }

}
