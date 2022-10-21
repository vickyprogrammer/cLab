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
use Application\Controller\CategoryController;
use Framework\Engine\RouterRequest;

/**
 * Application Controller is imported here
 * you can import any number of controllers
 */

require_once __DIR__ . '/../../controllers/CategoryController.php';

function CategoryRouter()
{
    $Auth = new AuthController();
    $Category = new CategoryController();

    return [
        'GET:/app/categories' => static function (RouterRequest $req) use ($Category, $Auth) {
            $Auth->AuthUser($req);
            $Category->Index($req);
        },
        'GET:/app/categories?page' => static function (RouterRequest $req) use ($Category, $Auth) {
            $Auth->AuthUser($req);
            $Category->Index($req);
        },
        'POST:/app/categories' => static function (RouterRequest $req) use ($Category, $Auth) {
            $Auth->AuthUser($req);
            $Category->CreateCategory($req);
        },
        'POST:/app/categories?id' => static function (RouterRequest $req) use ($Category, $Auth) {
            $Auth->AuthUser($req);
            $Category->GetCategory($req);
        },
        'PUT:/app/categories?id' => static function (RouterRequest $req) use ($Category, $Auth) {
            $Auth->AuthUser($req);
            $Category->EditCategory($req);
        },
        'DELETE:/app/categories?id' => static function (RouterRequest $req) use ($Category, $Auth) {
            $Auth->AuthUser($req);
            $Category->DeleteCategory($req);
        },
    ];
}
