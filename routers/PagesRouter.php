<?php
/**
 * Copyright: 2020
 *
 * Licence: MIT
 *
 * PagesRouter
 *
 * @summary short description for the file
 * @author Victor Sebiotimo <vickyprogrammer@gmail.com>
 *
 * Created at     : 05/07/2020 10:52 AM
 */


namespace Application\Router;

use Application\Controller\AuthController;
use Application\Controller\DashboardController;
use Application\Controller\ReportController;
use Framework\Engine\RouterRequest;

/**
 * Application Controller is imported here
 * you can import any number of controllers
 */

require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/CategoryController.php';
require_once __DIR__ . '/../controllers/ReportController.php';
require_once __DIR__ . '/pages/UsersRouter.php';
require_once __DIR__ . '/pages/CategoryRouter.php';
require_once __DIR__ . '/pages/ProductRouter.php';
require_once __DIR__ . '/pages/SupplierRouter.php';
require_once __DIR__ . '/pages/SupplyRouter.php';
require_once __DIR__ . '/pages/OrderRouter.php';

function PagesRouter()
{
    $Auth = new AuthController();
    $Dashboard = new DashboardController();
    $Report = new ReportController();

    return [
        // Dashboard routes
        'GET:/app' => static function (RouterRequest $req) use ($Dashboard, $Auth) {
            $Auth->AuthUser($req);
            $Dashboard->Index();
        },
        'GET:/app/dashboard' => static function (RouterRequest $req) use ($Dashboard, $Auth) {
            $Auth->AuthUser($req);
            $Dashboard->ShowPage($req);
        },

        // Chart routes
        'POST:/app/chart' => static function (RouterRequest $req) use ($Dashboard, $Auth) {
            $Auth->AuthUser($req);
            $Dashboard->getChartData();
        },

        // Report route
        'GET:/app/report/product?title&filter&value&from&to' => static function (RouterRequest $req) use ($Report, $Auth) {
            $Auth->AuthUser($req);
            $Report->Product($req);
        },
        'GET:/app/report/supplier?title&filter&value&from&to' => static function (RouterRequest $req) use ($Report, $Auth) {
            $Auth->AuthUser($req);
            $Report->Supplier($req);
        },
        'GET:/app/report/supplies?title&filter&value&from&to' => static function (RouterRequest $req) use ($Report, $Auth) {
            $Auth->AuthUser($req);
            $Report->Supplies($req);
        },
        'GET:/app/report/order?title&filter&value&from&to' => static function (RouterRequest $req) use ($Report, $Auth) {
            $Auth->AuthUser($req);
            $Report->Order($req);
        },

        // User routes
        UsersRouter(),

        // Product
        ProductRouter(),

        // Category routes
        CategoryRouter(),

        // Supplier routes
        SupplierRouter(),

        // Supply routes
        SupplyRouter(),

        // Order routes
        OrderRouter(),
    ];
}
