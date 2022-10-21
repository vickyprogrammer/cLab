<?php
/**
 * Copyright: 2019 - Routing
 *
 * Licence: MIT
 *
 * The class used for the navigation and routing based on the requested URL
 *
 * @summary Routing class
 * @author Mohammed Odunayo <vickyprogrammer@gmail.com>
 *
 * Created at     : 2019-07-29 02:03:16
 * Last modified  : 2019-10-03 19:05:43
 */


namespace Framework\Routing;

require_once __DIR__ . '/RouterRequest.class.php';
use Framework\Engine\RouterRequest;

/**
 * The class used for the navigation and routing based on the requested URL
 *
 * @package Framework
 */
class Routing
{

    /**
     * routers collections
     *
     * @var array
     */
    private $routers = [];

    /**
     * Application configuration
     *
     * @var array
     */
    private $appConfig;

    /**
     * Incoming request url
     *
     * @var string
     */
    private $requestURL;

    /**
     * Request parameters
     *
     * @var array
     */
    private $params = [];

    /**
     * Routing class constructor
     */
    public function __construct()
    {
        $this->appConfig = parse_ini_file('./configs/application.conf');
        $this->appConfig['app_baseUrl'] = ($this->appConfig['app_baseUrl'] === '/') ? '' : $this->appConfig['app_baseUrl'];
    }

    /**
     * Method for registering routes
     *
     * @param array $routes
     */
    final public function registerRoutes(array $routes): void
    {
        foreach ($routes as $key => $route) {
            if (is_int($key)) {
                $this->registerRoutes($route);
            } else {
                $this->routers[$key] = $route;
            }
        }
    }

    /**
     * Method for navigation based on the supplied URI
     *
     * @return void
     */
    final public function navigate(): void
    {
        $URL = $this->getURL();
        $baseURL = $this->getBaseURL();

        $this->requestURL = ($baseURL !== '/') ? str_replace($baseURL, '', $URL) : $URL;

        if ($this->requestURL != '/' && $this->requestURL[-1] == '/') {
            $this->requestURL = rtrim($this->requestURL, '/');
        }

        $links = array_keys($this->routers);
        /** @noinspection GlobalVariableUsageInspection */
        $verb = $_SERVER['REQUEST_METHOD'];

        foreach ($links as $link) {
            $chunks = explode('?', $this->requestURL);
            $newUrl = $chunks[0];
            $linkArr = explode(':', $link);

            if (count($chunks) > 1) {
                $arr = [$newUrl, $this->parseQueries($chunks[1])];
                $newUrl = implode('?', $arr);
            }

            if (count($linkArr) > 1) {
                if ($linkArr[0] === $verb && $linkArr[1] === $newUrl) {
                    $this->routers[$link]($this->getRouteObject());
                    return;
                }
            } else if ($verb === 'GET' && $linkArr[0] === $newUrl) {
                $this->routers[$link]($this->getRouteObject());
                return;
            }
        }

        header('Content-Type: text/html', true, 404);
        $this->routers['**']($this->getRouteObject());
    }

    /**
     * Get the current url request.
     *
     * @return string
     */
    private function getURL(): string
    {
        return $_SERVER['REQUEST_URI'];
        // return filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
    }

    /**
     * get the base url from application configuration
     *
     * @return string
     */
    private function getBaseURL(): string
    {
        return $this->appConfig['app_baseUrl'];
    }

    /**
     * Parse the query part of the url
     *
     * @param string $queryString
     * @return string
     */
    private function parseQueries(string $queryString): string
    {
        $queries = explode('&', $queryString);
        $parsedQuery = [];

        foreach ($queries as $query) {
            $data = explode('=', $query);
            $this->params[$data[0]] = (count($data) > 1) ? urldecode($data[1]) : null;
            $parsedQuery[] = $data[0];
        }

        return implode('&', $parsedQuery);
    }

    private function getRouteObject(): RouterRequest
    {
        return new RouterRequest($this->requestURL, $this->params, $this->appConfig);
    }
}