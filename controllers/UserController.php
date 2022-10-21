<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * UserController
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 06/07/2020 2:47 PM
 */


namespace Application\Controller;

/**
 * Import your models here.
 */
require_once __DIR__ . '/../models/UsersModel.php';

use Application\Model\UsersModel;
use Framework\Engine\Controller;
use Framework\Engine\RouterRequest;

/**
 * UserController class
 *
 * @package Application
 */
class UserController extends Controller
{
    private $UsersModel;

    public function __construct()
    {
        parent::__construct();
        $this->UsersModel = new UsersModel();
    }

    final public function Profile(RouterRequest $req): void
    {
        $this->View->assign('title', 'User Profile');
        $this->View->assign('page', 'user');
        $this->View->assign('data', [
            'user' => $req->Store['user']
        ]);
        $this->displayPage('app/index');
    }

    final public function UpdateProfile(RouterRequest $req): void
    {
        $data = [
            'first_name' => $req->Body->first_name,
            'last_name' => $req->Body->last_name,
            'phone' => $req->Body->phone,
        ];
        $this->UsersModel->updateById($req->Store['user']->id, $data);
        $this->displayJSON([
            'success' => true,
            'message' => 'Profile Updated Successfully',
        ]);
    }

    final public function Index(RouterRequest $req): void
    {
        $totalAccounts = $this->UsersModel->countQuery();
        $page = isset($req->params['page']) ? $req->params['page'] : 1;
        $pagination = $this->getPagination($page, $totalAccounts);
        $accounts = $this->UsersModel->getAll(
            [], false,
            $pagination['limit'],
            $pagination['offset'],
            ['created_at DESC']
        );

        $this->View->assign('title', 'Accounts');
        $this->View->assign('page', 'accounts');
        $this->View->assign('data', [
            'user' => $req->Store['user'],
            'accounts' => $accounts,
            'pagination' => $pagination,
        ]);
        $this->displayPage('app/index');
    }

    final public function GetAccount(RouterRequest $req): void
    {
        $account = (array)$this->UsersModel->getAll($req->params)[0];
        $account['password'] = '';
        $account['role_name'] = $account['role'] == 1 ? 'Super Admin' : 'Admin';
        $this->displayJSON([
            'success' => true,
            'data' => (object)$account,
        ]);
    }

    final public function CreateAccount(RouterRequest $req): void
    {
        $data = [
            'email' => $req->Body->email,
            'password' => md5($req->Body->password),
            'role' => $req->Body->role,
        ];
        $exist = $this->UsersModel->getByField('email', $data['email']);
        if (count($exist) > 0) {
            $this->displayJSON([
                'success' => false,
                'message' => 'Error: User with email already exist!',
            ]);
        } else {
            $this->UsersModel->insertRecord($data);
            $this->displayJSON([
                'success' => true,
                'data' => 'Account Created Successfully',
            ]);
        }
    }

    final public function EditAccount(RouterRequest $req): void
    {
        $data = [];
        if (isset($req->Body->password) && strlen($req->Body->password) >= 6) {
            $data['password'] = md5($req->Body->password);
        }
        $data['email'] = $req->Body->email;
        $data['role'] = $req->Body->role;
        $user = $this->UsersModel->getById($req->params['id'])[0];
        if ($data['email'] != $user->email) {
            $exist = $this->UsersModel->getByField('email', $data['email']);
            if (count($exist) > 0) {
                $this->displayJSON([
                    'success' => false,
                    'message' => 'Error: User with email already exist!',
                ]);
            }
        }
        $this->UsersModel->updateById($req->params['id'], $data);
        $this->displayJSON([
            'success' => true,
            'message' => 'Account Updated Successfully',
        ]);
    }
}
