<?php

/*
 *  @Auther : Adisorn Lamsombuth
 *  @Email : postyim@gmail.com
 *  @Website : esabay.com 
 */

namespace App\Controllers;

/**
 * Description of AuthenticationController
 *
 * @author R-D-6
 */
class AuthenticationController extends \BaseController {

    public function login() {
        if (!\Request::isMethod('post')) {
            $data['page'] = array(
                'title' => 'เข้าสู่ระบบ'
            );
            return \View::make('mod_authentication.login', $data);
        } else {
            $rules = array(
                'username' => 'required',
                'password' => 'required'
            );
            $validator = \Validator::make(\Input::all(), $rules);
            if ($validator->fails()) {
                return \Response::json(array(
                            'error' => array(
                                'status' => FALSE,
                                'message' => $validator->messages()
                            ), 400));
            } else {
                try {
                    \Auth::attempt(array('username' => trim(\Input::get('username')), 'password' => trim(\Input::get('password'))));
                } catch (\UserNotFoundException $e) {
                    echo $e;
                } catch (\UserUnverifiedException $e) {
                    echo $e;
                } catch (\UserDisabledException $e) {
                    echo $e;
                } catch (\UserDeletedException $e) {
                    echo $e;
                } catch (\UserPasswordIncorrectException $e) {
                    echo $e;
                }
                return \Response::json(array(
                            'error' => array(
                                'status' => TRUE
                            ), 200));
            }
        }
    }

    public function logout() {
        \Auth::logout();
        return \Redirect::to('login');
    }

}
