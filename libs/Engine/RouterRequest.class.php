<?php /** @noinspection GlobalVariableUsageInspection */

/**
 * Copyright: 2019 - Request
 *
 * Licence: MIT
 *
 * The request class.
 *
 * @summary Request class
 * @author Mohammed Odunayo <vickyprogrammer@gmail.com>
 *
 * Created at     : 2019-07-29 02:03:16
 * Last modified  : 2019-09-01 18:24:08
 */

namespace Framework\Engine {

    /**
     * Class RouterRequest
     *
     * @package Framework\Engine
     */
    class RouterRequest
    {
        /**
         * Request URL
         *
         * @var string
         */
        public $url;

        /**
         * Request Parameters
         *
         * @var array
         */
        public $params;

        /**
         * Application Configuration
         *
         * @var array
         */
        public $appConfig;

        /**
         * Global GET variable
         *
         * @var array
         */
        public $GET;

        /**
         * Global POST variable
         *
         * @var array
         */
        public $POST;

        /**
         * Request Body variable
         *
         * @var mixed
         */
        public $Body;

        /**
         * Store variable
         *
         * @var array
         */
        public $Store;

        /**
         * Global FILES variable
         *
         * @var array
         */
        public $FILES;

        /**
         * Global COOKIE variable
         *
         * @var Cookie
         */
        public $COOKIE;

        /**
         * Global SESSION variable
         *
         * @var Session
         */
        public $SESSION;

        /**
         * RouterRequest constructor.
         * @param string $url
         * @param array $params
         * @param array $appConfig
         */
        public function __construct(string $url, array $params, array $appConfig)
        {
            $this->url = $url;
            $this->params = $params;
            $this->appConfig = $appConfig;
            $this->GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->Body = $this->getRequestBody();
            $this->Store = [];
            $this->COOKIE = new Cookie();
            $this->SESSION = new Session();
            $this->FILES = $_FILES;
        }
        
        private function apache_request_headers() {
            $arh = array();
            $rx_http = '/\AHTTP_/';
            foreach($_SERVER as $key => $val) {
                if( preg_match($rx_http, $key) ) {
                    $arh_key = preg_replace($rx_http, '', $key);
                    $rx_matches = array();
                    // do some nasty string manipulations to restore the original letter case
                    // this should work in most cases
                    $rx_matches = explode('_', strtolower($arh_key));
                    if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
                        foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
                        $arh_key = implode('-', $rx_matches);
                    }
                    $arh[$arh_key] = $val;
                }
            }
            if(isset($_SERVER['CONTENT_TYPE'])) $arh['Content-Type'] = $_SERVER['CONTENT_TYPE'];
            if(isset($_SERVER['CONTENT_LENGTH'])) $arh['Content-Length'] = $_SERVER['CONTENT_LENGTH'];
            return( $arh );
        }

        /**
         * Get the current request body data
         *
         * @return mixed
         */
        private function getRequestBody()
        {
            $head = $this->apache_request_headers();
            $body = file('php://input');
            
            switch (count($body)) {
                case 0:
                    return null;
                    break;
                case 1:
                    if ($head['Content-Type'] && $head['Content-Type'] === 'application/json') {
                        try {
                            return json_decode($body[0]);
                        } catch (Exception $e) {
                            handleError($e);
                        }
                    }
                    return $body[0];
                    break;
                default:
                    if ($head['Content-Type'] && $head['Content-Type'] === 'application/json') {
                        $data = [];
                        foreach ($body as $value) {
                            try {
                                $data[] = json_decode($value);
                            } catch (Exception $e) {
                                handleError($e);
                            }
                        }
                        return $data;
                    }
                    return $body;
                    break;
            }
        }
    }
}