<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * UsersRouter
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 11/07/2020 7:08 AM
 */


namespace Application\Router;

use Application\Controller\AuthController;
use Application\Controller\UserController;
use Framework\Engine\RouterRequest;

/**
 * Application Controller is imported here
 * you can import any number of controllers
 */

require_once __DIR__ . '/../../controllers/UserController.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

function UsersRouter()
{
    $Auth = new AuthController();
    $UserProfile = new UserController();

    return [
        'GET:/app/user' => static function (RouterRequest $req) use ($UserProfile, $Auth) {
            $Auth->AuthUser($req);
            $UserProfile->Profile($req);
        },
        'POST:/app/user/update' => static function (RouterRequest $req) use ($UserProfile, $Auth) {
            $Auth->AuthUser($req);
            $UserProfile->UpdateProfile($req);
        },
        'GET:/app/accounts' => static function (RouterRequest $req) use ($UserProfile, $Auth) {
            $Auth->AuthUser($req);
            $Auth->IsSuperAdmin($req, true);
            $UserProfile->Index($req);
        },
        'POST:/app/accounts?id' => static function (RouterRequest $req) use ($UserProfile, $Auth) {
            $Auth->AuthUser($req);
            $Auth->IsSuperAdmin($req);
            $UserProfile->GetAccount($req);
        },
        'GET:/app/accounts?page' => static function (RouterRequest $req) use ($UserProfile, $Auth) {
            $Auth->AuthUser($req);
            $Auth->IsSuperAdmin($req, true);
            $UserProfile->Index($req);
        },
        'POST:/app/accounts' => static function (RouterRequest $req) use ($UserProfile, $Auth) {
            $Auth->AuthUser($req);
            $Auth->IsSuperAdmin($req);
            $UserProfile->CreateAccount($req);
        },
        'PUT:/app/accounts?id' => static function (RouterRequest $req) use ($UserProfile, $Auth) {
            $Auth->AuthUser($req);
            $Auth->IsSuperAdmin($req);
            $UserProfile->EditAccount($req);
        },
    ];
}
