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
        $data = array(
            'title' => 'ระเบียนคอมพิวเตอร์',
            'breadcrumbs' => array(
                'ภาพรวมระบบ' => 'backend',
                'ภาพรวมฝ่ายเทคโนโลยีสารเทศ' => 'mis/backend',
                'ระเบียนคอมพิวเตอร์' => '#'
            )
        );
        return \View::make('mod_mis.computer.admin.index', $data);
    }

}
