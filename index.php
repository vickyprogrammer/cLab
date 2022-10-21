<?php
/**
 * Copyright: 2019
 *
 * Licence: MIT
 *
 * This is the main entry point for the framework.
 *
 * @summary this is the framework bootstrap.
 * @author Mohammed Odunayo <vickyprogrammer@gmail.com>
 *
 * Created at     : 2019-07-29 00:31:24
 * Last modified  : 2019-09-01 14:51:22
 */

header('Cache-Control: no-cache');
header('Pragma: no-cache');

require_once './libs/autoLoader.php';

use Application\Router\AppRouter;

$router = new AppRouter();
