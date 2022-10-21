<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * AuthRouter
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 04/07/2020 11:05 AM
 */


namespace Application\Router;

use Framework\Engine\RouterRequest;

/**
 * Application Controller is imported here
 * you can import any number of controllers
 */

require_once __DIR__ . '/../controllers/AuthController.php';

use Application\Controller\AuthController;

function AuthRouter()
{
    $Controller = new AuthController();

    return [
        'GET:/auth' => static function (RouterRequest $req) use ($Controller) {
            $Controller->Auth($req);
        },
        'POST:/auth/login' => static function (RouterRequest $req) use ($Controller) {
            $Controller->Login($req);
        },
        'POST:/auth/register' => static function (RouterRequest $req) use ($Controller) {
            $Controller->Register($req);
        },
        'GET:/auth/logout' => static function (RouterRequest $req) use ($Controller) {
            $Controller->Logout($req);
        }
    ];
}
