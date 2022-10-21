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
use Application\Controller\OrderController;
use Framework\Engine\RouterRequest;

/**
 * Application Controller is imported here
 * you can import any number of controllers
 */

require_once __DIR__ . '/../../controllers/OrderController.php';

function OrderRouter()
{
    $Auth = new AuthController();
    $Order = new OrderController();

    return [
        'GET:/app/orders' => static function (RouterRequest $req) use ($Order, $Auth) {
            $Auth->AuthUser($req);
            $Order->Index($req);
        },
        'GET:/app/orders?page' => static function (RouterRequest $req) use ($Order, $Auth) {
            $Auth->AuthUser($req);
            $Order->Index($req);
        },
        'POST:/app/orders' => static function (RouterRequest $req) use ($Order, $Auth) {
            $Auth->AuthUser($req);
            $Order->CreateOrder($req);
        },
        'POST:/app/orders?id' => static function (RouterRequest $req) use ($Order, $Auth) {
            $Auth->AuthUser($req);
            $Order->GetOrder($req);
        },
        'PUT:/app/orders?id' => static function (RouterRequest $req) use ($Order, $Auth) {
            $Auth->AuthUser($req);
            $Auth->IsSuperAdmin($req);
            $Order->EditOrder($req);
        },
        'DELETE:/app/orders?id' => static function (RouterRequest $req) use ($Order, $Auth) {
            $Auth->AuthUser($req);
            $Auth->IsSuperAdmin($req);
            $Order->DeleteOrder($req);
        },
    ];
}
