<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * AuthController
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 04/07/2020 10:55 AM
 */


namespace Application\Controller;

/**
 * Import your models here.
 */
require_once __DIR__ . '/../models/UsersModel.php';

use Application\Model\UsersModel;
use Framework\Engine\Controller as parentAlias;
use Framework\Engine\RouterRequest;

/**
 * AuthController class
 *
 * @package Application
 */
class AuthController extends parentAlias
{
    private $UsersModel;

    public function __construct()
    {
        parent::__construct();
        $this->UsersModel = new UsersModel();
    }

    final public function AuthUser(RouterRequest &$req): void
    {
        $req->SESSION->authUserSession('user', $this->appConfig['app_baseUrl'] . '/auth');
        $user = $this->UsersModel->getById($req->SESSION->get('user', 0))[0];
        $req->Store['user'] = $user;
        $this->View->assign('account_name', $user->first_name ? "$user->first_name $user->last_name" : $user->email);
    }

    final public function Auth(RouterRequest $req): void
    {
        if (!$req->SESSION->get('user', false)) {
            $this->View->assign('title', 'User Authentication');
            $this->View->assign('data', $req->appConfig);
            $this->displayPage('auth/auth');
        } else {
            $this->redirectTo($this->appConfig['app_baseUrl'] . '/app');
        }
    }

    final public function IsSuperAdmin(RouterRequest $req, bool $redirect = false): void
    {
        if ($req->Store['user']->role != 1) {
            if (!$redirect) {
                $this->displayJSON([
                    'success' => false,
                    'message' => "Unauthorized operation",
                ], 401);
            } else {
                $this->redirectTo($this->appConfig['app_baseUrl']);
            }
        }
    }

    final public function Login(RouterRequest $req): void
    {
        $data = [
            'email' => $req->POST['email'],
            'password' => md5($req->POST['password']),
        ];
        $exist = $this->UsersModel->getByField('email', $data['email']);
        if (count($exist) > 0) {
            if ($exist[0]->password === $data['password']) {
                $req->SESSION->set('user', $exist[0]->id);
                $this->displayJSON([
                    'success' => true,
                    'data' => $exist[0],
                ]);
            } else {
                $this->displayJSON([
                    'success' => false,
                    'message' => 'Error: Invalid email/password combination!',
                ]);
            }
        } else {
            $this->displayJSON([
                'success' => false,
                'message' => 'Error: Invalid email/password combination!',
            ]);
        }
    }

    final public function Register(RouterRequest $req): void
    {
        $data = [
            'email' => $req->POST['email'],
            'password' => md5($req->POST['password']),
        ];
        $exist = $this->UsersModel->getByField('email', $data['email']);
        if (count($exist) > 0) {
            $this->displayJSON([
                'success' => false,
                'message' => 'Error: User with email already exist!',
            ]);
        } else {
            if ($this->UsersModel->countQuery(['role' => 1]) < 1) {
                $data['role'] = 1;
            }

            $this->UsersModel->insertRecord($data);
            $user = $this->UsersModel->getByField('email', $data['email'])[0];
            $req->SESSION->set('user', $user->id);
            $this->displayJSON([
                'success' => true,
                'data' => $user,
            ], 201);
        }
    }

    final public function Logout(RouterRequest $req): void
    {
        $req->SESSION->remove('user');
        $req->SESSION->destroy();
        $this->redirectTo($this->appConfig['app_baseUrl'] . '/auth');
    }
}
