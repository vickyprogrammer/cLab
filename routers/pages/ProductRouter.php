<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * ProductRouter
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 11/07/2020 7:25 AM
 */


namespace Application\Router;

use Application\Controller\AuthController;
use Application\Controller\ProductController;
use Framework\Engine\RouterRequest;

/**
 * Application Controller is imported here
 * you can import any number of controllers
 */

require_once __DIR__ . '/../../controllers/ProductController.php';

function ProductRouter()
{
    $Auth = new AuthController();
    $Products = new ProductController();

    return [
        'GET:/app/products' => static function (RouterRequest $req) use ($Products, $Auth) {
            $Auth->AuthUser($req);
            $Products->Index($req);
        },
        'GET:/app/products?page' => static function (RouterRequest $req) use ($Products, $Auth) {
            $Auth->AuthUser($req);
            $Products->Index($req);
        },
        'POST:/app/products' => static function (RouterRequest $req) use ($Products, $Auth) {
            $Auth->AuthUser($req);
            $Products->CreateProduct($req);
        },
        'POST:/app/products/upload' => static function (RouterRequest $req) use ($Products, $Auth) {
            $Auth->AuthUser($req);
            $Products->UploadProducts($req);
        },
        'POST:/app/products?id' => static function (RouterRequest $req) use ($Products, $Auth) {
            $Auth->AuthUser($req);
            $Products->GetProduct($req);
        },
        'PUT:/app/products?id' => static function (RouterRequest $req) use ($Products, $Auth) {
            $Auth->AuthUser($req);
            $Products->EditProduct($req);
        },
        'DELETE:/app/products?id' => static function (RouterRequest $req) use ($Products, $Auth) {
            $Auth->AuthUser($req);
            $Products->DeleteProduct($req);
        },
    ];
}
