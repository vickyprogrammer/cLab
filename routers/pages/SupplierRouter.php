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
use Application\Controller\SupplierController;
use Framework\Engine\RouterRequest;

/**
 * Application Controller is imported here
 * you can import any number of controllers
 */

require_once __DIR__ . '/../../controllers/SupplierController.php';

function SupplierRouter()
{
    $Auth = new AuthController();
    $Supplier = new SupplierController();

    return [
        'GET:/app/suppliers' => static function (RouterRequest $req) use ($Supplier, $Auth) {
            $Auth->AuthUser($req);
            $Supplier->Index($req);
        },
        'GET:/app/suppliers?page' => static function (RouterRequest $req) use ($Supplier, $Auth) {
            $Auth->AuthUser($req);
            $Supplier->Index($req);
        },
        'POST:/app/suppliers' => static function (RouterRequest $req) use ($Supplier, $Auth) {
            $Auth->AuthUser($req);
            $Supplier->CreateSupplier($req);
        },
        'POST:/app/suppliers?id' => static function (RouterRequest $req) use ($Supplier, $Auth) {
            $Auth->AuthUser($req);
            $Supplier->GetSupplier($req);
        },
        'PUT:/app/suppliers?id' => static function (RouterRequest $req) use ($Supplier, $Auth) {
            $Auth->AuthUser($req);
            $Supplier->EditSupplier($req);
        },
        'DELETE:/app/suppliers?id' => static function (RouterRequest $req) use ($Supplier, $Auth) {
            $Auth->AuthUser($req);
            $Supplier->DeleteSupplier($req);
        },
    ];
}
