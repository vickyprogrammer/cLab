<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * CategoryRouter
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 11/07/2020 7:17 AM
 */


namespace Application\Router;

use Application\Controller\AuthController;
use Application\Controller\SupplyController;
use Framework\Engine\RouterRequest;

/**
 * Application Controller is imported here
 * you can import any number of controllers
 */

require_once __DIR__ . '/../../controllers/SupplyController.php';

function SupplyRouter()
{
    $Auth = new AuthController();
    $Supply = new SupplyController();

    return [
        'GET:/app/supplies' => static function (RouterRequest $req) use ($Supply, $Auth) {
            $Auth->AuthUser($req);
            $Supply->Index($req);
        },
        'GET:/app/supplies?page' => static function (RouterRequest $req) use ($Supply, $Auth) {
            $Auth->AuthUser($req);
            $Supply->Index($req);
        },
        'POST:/app/supplies' => static function (RouterRequest $req) use ($Supply, $Auth) {
            $Auth->AuthUser($req);
            $Supply->CreateSupply($req);
        },
        'POST:/app/supplies?id' => static function (RouterRequest $req) use ($Supply, $Auth) {
            $Auth->AuthUser($req);
            $Supply->GetSupply($req);
        },
        'PUT:/app/supplies?id' => static function (RouterRequest $req) use ($Supply, $Auth) {
            $Auth->AuthUser($req);
            $Auth->IsSuperAdmin($req);
            $Supply->EditSupply($req);
        },
        'DELETE:/app/supplies?id' => static function (RouterRequest $req) use ($Supply, $Auth) {
            $Auth->AuthUser($req);
            $Auth->IsSuperAdmin($req);
            $Supply->DeleteSupply($req);
        },
    ];
}
