<?php
/**
 * Copyright: 2019 - Setup
 *
 * Licence: MIT
 *
 * The setup engine class
 *
 * @summary Setup class
 * @author Mohammed Odunayo <vickyprogrammer@gmail.com>
 *
 * Created at     : 2019-07-30 09:14:25
 * Last modified  : 2019-10-02 15:56:03
 */


namespace Framework\Engine {

    use Smarty;

    /**
     * The framework setup engine class
     */
    class FrameworkSetup
    {
        /**
         * App Configuration
         *
         * @var array
         */
        public $appConfig;

        /**
         * @var Smarty
         */
        static $Smarty;

        /**
         * The engine constructor
         */
        public function __construct()
        {
            $this->appConfig = parse_ini_file('./configs/application.conf');

            if (!isset(self::$Smarty)) {
                $smarty = new Smarty();
                $smarty->setTemplateDir('./views/templates/');
                $smarty->setCompileDir('./views/templates_c/');
                $smarty->setConfigDir('./configs/');
                $smarty->setCacheDir('./cache/');
                $cacheBurst = '?cache=' . $this->appConfig['app_version'];

                if ($this->appConfig['app_env'] === 'development') {
                    $smarty->debugging = true;
                    $cacheBurst = '?cache=' . time();
                }

                $baseUrl = ($this->appConfig['app_baseUrl'] === '/') ? '' : $this->appConfig['app_baseUrl'];
                $smarty->assign('baseUrl', $baseUrl);
                $smarty->assign('appName', $this->appConfig['app_name']);
                $smarty->assign('appSummary', $this->appConfig['app_summary']);
                $smarty->assign('rootUrl', $this->appConfig['app_rootUrl']);
                $smarty->assign('cache', $cacheBurst);

                self::$Smarty = $smarty;
            }
        }
    }
}