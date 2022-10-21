<?php
/**
 * Copyright: 2019 - ErrorHandler
 *
 * Licence: MIT
 *
 * The error handling function
 *
 * @summary ErrorHandling
 * @author Mohammed Odunayo <vickyprogrammer@gmail.com>
 *
 * Created at     : 2019-07-30 09:14:25
 * Last modified  : 2019-09-01 18:35:56
 */

namespace Framework\Engine;

use Exception;
use RuntimeException;
use SmartyException;

$appConfig = parse_ini_file('./configs/application.conf');
$evn = $appConfig['app_env'];

if ($evn === 'development') {
    error_reporting(E_ALL);
} else {
    error_reporting(E_ALL);
}

/**
 * @param int $type
 * @param mixed $msg
 * @param bool $log
 */
$errorHandle = static function (int $type, $msg, bool $log = true): void {
    $errorType = '';
    global $appConfig;

    switch ($type) {
        case E_NOTICE:
            $errorType = 'Notice';
            break;
        case E_WARNING:
            $errorType = 'Warning';
            break;
        case E_ERROR:
        default:
            $errorType = 'Error';
    }

    $message = "<strong>$errorType: </strong><br/>$msg";
    $setup = new FrameworkSetup();
    $setup::$Smarty->assign('title', 'Hoops!!! Internal Server Error');
    $setup::$Smarty->assign('error', [
        'code' => '500',
        'message' => $message,
        'gotoName' => 'Home',
        'gotoLink' => $appConfig['app_baseUrl'],
    ]);

    if ($log) {
        $file = 'log/unhandled_error.json';
        $fileData = [];
        $data = [
            'created_at' => date('D, d M Y H:i:s'),
            'message' => $msg,
            'code' => null,
            'file' => null,
            'line' => null,
            'trace' => null,
            'type' => $errorType,
        ];

        if (file_exists($file)) {
            $str = file_get_contents($file);
            $fileData = json_decode($str);
        }

        if (count($fileData) === 300) {
            array_shift($fileData);
        }

        $fileData[] = $data;
        $output = json_encode($fileData, JSON_PRETTY_PRINT);

        file_put_contents($file, $output);
    }
    
    header('Content-Type: text/html', true, 500);

    try {
        $setup::$Smarty->display('views/templates/error.tpl');
        die();
    } catch (SmartyException $e) {
        die($e->getMessage());
    } catch (Exception $e) {
        die($e->getMessage());
    }
};

/**
 * Error handler function
 *
 * @param mixed $error
 * @return void
 */
function handleError($error): void
{
    global $errorHandle;
    $file = 'log/handled_error.json';
    $fileData = [];
    $data = [];
    $message = '';

    if (file_exists($file)) {
        $str = file_get_contents($file);
        $fileData = json_decode($str);
    }

    if ($error instanceof Exception || $error instanceof RuntimeException) {
        $data = [
            'created_at' => date('D, d M Y H:i:s'),
            'message' => $error->getMessage(),
            'code' => $error->getCode(),
            'file' => $error->getFile(),
            'line' => $error->getLine(),
            'trace' => $error->getTrace(),
            'type' => 'Exception Error',
        ];
        $message = $error->getMessage();
    } elseif (is_array($error)) {
        $data = [
            'created_at' => date('D, d M Y H:i:s'),
            'message' => $error[2],
            'code' => $error[0],
            'file' => null,
            'line' => null,
            'trace' => null,
            'type' => 'PDO Error',
        ];
        $message = $error[2];
    } else {
        $data = [
            'created_at' => date('D, d M Y H:i:s'),
            'message' => json_encode($error, JSON_PRETTY_PRINT),
            'code' => null,
            'file' => null,
            'line' => null,
            'trace' => null,
            'type' => 'Unknown Error',
        ];
        $message = json_encode($error, JSON_PRETTY_PRINT);
    }

    if (count($fileData) === 300) {
        array_shift($fileData);
    }

    $fileData[] = $data;
    $output = json_encode($fileData, JSON_PRETTY_PRINT);

    file_put_contents($file, $output);

    $errorHandle(E_ERROR, $message, false);
}

set_error_handler($errorHandle, E_ALL);
