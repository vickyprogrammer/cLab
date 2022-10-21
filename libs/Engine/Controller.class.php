<?php
/**
 * Copyright: 2019 - Controller
 *
 * Licence: MIT
 *
 * The controller parent class
 *
 * @summary Controller class
 * @author Mohammed Odunayo <vickyprogrammer@gmail.com>
 *
 * Created at     : 2019-07-30 09:14:25
 * Last modified  : 2019-10-02 15:51:41
 */

namespace Framework\Engine {

    use Exception;
    use Framework\Engine\FrameworkSetup as Setup;
    use SmartyException;
    use Smarty;

    /**
     * The framework controller class
     */
    class Controller extends Setup
    {
        /**
         * @var Smarty
         */
        public $View;

        /**
         * @var int
         */
        private $PaginationLimit = 50;

        /**
         * Controller constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->View = Setup::$Smarty;
        }

        /**
         * Renders the template file specified with the $file parameter and return the response code 200 if $statusCode is not specified.
         *
         * @param string $file
         * @param integer $statusCode
         * @return void
         */
        final public function displayPage(string $file, int $statusCode = 200): void
        {
            header('Content-Type: text/html', true, $statusCode);
            try {
                $this->View->display("views/templates/$file.tpl");
            } catch (SmartyException $e) {
                handleError($e);
            } catch (Exception $e) {
                handleError($e);
            }
            die();
        }

        /**
         * Render the value of $response as a json data and return the response code 200 if $statusCode is not specified.
         *
         * @param array $response
         * @param integer $statusCode
         * @return void
         */
        final public function displayJSON(array $response, int $statusCode = 200): void
        {
            header('Content-Type: application/json', true, $statusCode);
            $res = json_encode($response, JSON_PRETTY_PRINT);
            echo $res;
            die();
        }

        /**
         * Render the value of $response as a xml data and return the response code 200 if $statusCode is not specified.
         *
         * @param array $response
         * @param integer $statusCode
         * @return void
         */
        final public function displayXML(array $response, int $statusCode = 200): void
        {
            header('Content-Type: application/xml', true, $statusCode);
            $res = xmlrpc_encode($response);
            echo $res;
            die();
        }

        /**
         * Render the value of $response as a text data and return the response code 200 if $statusCode is not specified.
         *
         * @param array $response
         * @param integer $statusCode
         * @return void
         */
        final public function displayTXT(array $response, int $statusCode = 200): void
        {
            header('Content-Type: text/plain', true, $statusCode);
            $res = serialize($response);
            echo $res;
            die();
        }

        /**
         * Redirect to the specified location
         *
         * @param string $location
         * @return void
         */
        final public function redirectTo(string $location): void
        {
            header("Location: $location", true);
            die();
        }

        /**
         * Swap array key with the value of the field specified
         * @param string $field
         * @param array $data
         * @return array
         */
        final public function switchArrayKeys(string $field, array $data): array
        {
            $values = [];
            foreach ($data as $obj) {
                $values[$obj->$field] = $obj;
            }
            return $values;
        }

        /**
         * Calculate pagination
         * @param int $page
         * @param int $total
         * @return array
         */
        final public function getPagination(int $page, int $total): array
        {
            $end = $this->PaginationLimit * $page;
            $start = $end - $this->PaginationLimit + 1;
            $totalItems = $total === 0 ? 1 : $total;
            return [
                'limit' => $this->PaginationLimit,
                'currentPage' => $page,
                'totalPages' => ceil($totalItems / $this->PaginationLimit),
                'offset' => $this->PaginationLimit * $page - $this->PaginationLimit,
                'totalItems' => $total,
                'label' => "$start – $end of $totalItems",
            ];
        }
    }
}