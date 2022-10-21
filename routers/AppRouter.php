<?php
/**
 * Copyright: 2019
 *
 * Licence: MIT
 *
 * This is the framework main router
 *
 * @summary short description for the file
 * @author Mohammed Odunayo <vickyprogrammer@gmail.com>
 *
 * Created at     : 2019-07-29 02:24:20
 * Last modified  : 2019-09-01 19:09:39
 */


namespace Application\Router;

use Framework\Engine\Controller;
use Framework\Routing\Routing;

/**
 * Import all your routers here
 */
require_once __DIR__ . '/AuthRouter.php';
require_once __DIR__ . '/PagesRouter.php';

/**
 * AppRouter class
 *
 * @package Application
 */
class AppRouter extends Routing
{

    /**
     * AppRouter constructor
     */
    public function __construct()
    {
        /**
         * Register all your application routes here
         */
        parent::__construct();

        $Control = new Controller();

        $this->registerRoutes([
            // Routers goes here
            'GET:/' => static function () use ($Control) {
                $Control->redirectTo($Control->appConfig['app_baseUrl'] . '/app');
            },
            AuthRouter(),
            PagesRouter(),
            '**' => static function () use ($Control) {
                $Control->View->assign('title', 'Hoops!!! Page Not Found');
                // $this->assign("error", [
                //   "code" => "404",
                //   "message" => "The requested path could not be found visit: ",
                //   "gotoName" => "Home",
                //   "gotoLink" => $req["appConfig"]["app_baseUrl"],
                // ]);
                $Control->displayPage('error', 404);
            },
        ]);

        $this->navigate();
    }
}
