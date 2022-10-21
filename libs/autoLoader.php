<?php
/**
 * Copyright: 2019
 *
 * Licence: MIT
 *
 * Framework autoLoader
 *
 * @summary autoLoader
 * @author Mohammed Odunayo <vickyprogrammer@gmail.com>
 *
 * Created at     : 2019-07-29 08:28:21
 * Last modified  : 2019-09-01 18:39:48
 */

require_once __DIR__ . '/errorHandler.php';
require_once __DIR__ . '/Smarty/Smarty.class.php';
require_once __DIR__ . '/Engine/Cookie.class.php';
require_once __DIR__ . '/Engine/Session.class.php';
require_once __DIR__ . '/Engine/FrameworkSetup.class.php';
require_once __DIR__ . '/Engine/Controller.class.php';
require_once __DIR__ . '/Engine/Model.class.php';
require_once __DIR__ . '/Engine/Routing.class.php';
require_once __DIR__ . '/../routers/AppRouter.php';
