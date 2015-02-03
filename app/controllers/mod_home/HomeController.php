<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com 
 */

namespace App\Controllers;

/**
 * Description of HomeController
 *
 * @author R-D-6
 */
class HomeController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('auth', array('except' => 'login'));
    }

    public function index() {
        $check = \User::find((\Auth::check() ? \Auth::user()->id : 0));
        $data['page'] = array(
            'title' => 'ภาพรวมระบบ'
        );
        if (\Auth::check()) {
            if ($check->is('administrator')) {
                return \View::make('mod_home.admin.index', $data);
            } elseif ($check->is('admin')) {
                return \View::make('mod_home.admin.index', $data);
            } elseif ($check->is('employee')) {
                return \View::make('mod_home.employee.index', $data);
            } elseif ($check->is('mis')) {
                return \View::make('mod_home.employee.mis.index', $data);
            } elseif ($check->is('hr')) {
                return \View::make('mod_home.employee.hr.index', $data);
            }
        } else {
            return \View::make('home.guest.index', $data);
        }
    }

}
