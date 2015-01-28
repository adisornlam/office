<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com
 */

namespace App\Controllers\Backend;

/**
 * Description of MisController
 *
 * @author Administrator
 */
class MisController extends \BaseController {

    public function index() {
        $data = array(
            'title' => 'ภาพรวมฝ่ายเทคโนโลยีสารเทศ',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => 'backend',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => '#'
            )
        );
        return \View::make('backend.mod_mis.home.admin.index', $data);
    }

}
