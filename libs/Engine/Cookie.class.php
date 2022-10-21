<?php
/**
 * Copyright: 2019 - Cookie
 *
 * Licence: MIT
 *
 * The cookie controller class
 *
 * @summary Cookie class
 * @author Mohammed Odunayo <vickyprogrammer@gmail.com>
 *
 * Created at     : 2019-09-01 14:48:34
 * Last modified  : 2019-09-01 16:48:42
 */

namespace Framework\Engine {

    class Cookie
    {

        /**
         * Get a cookie value
         *
         * @param string $name
         * @param null $default
         * @return string|null
         */
        final public function get(string $name, $default = null): string
        {
            if (isset($_COOKIE[$name])) {
                return $_COOKIE[$name];
            }
            return $default;
        }

        /**
         * Get all cookies in an associative array
         *
         * @return array
         */
        final public function getAll(): array
        {
            return $_COOKIE;
        }

        /**
         * Set a cookie value
         *
         * @param string $name
         * @param string $value
         * @param integer $expire
         * @param string $path
         * @param string $domain
         * @param boolean $secure
         * @param boolean $httponly
         * @return boolean
         */
        final public function set(string $name, string $value, int $expire = 43200, string $path = '', string $domain = '', bool $secure = false, bool $httponly = false): bool
        {
            return setcookie($name, $value, mktime() + $expire, $path, $domain, $secure, $httponly);
        }

        /**
         * Remove a cookie value
         *
         * @param string $name
         * @param string $path
         * @param string $domain
         * @return boolean
         */
        final public function remove(string $name, string $path = '', string $domain = ''): bool
        {
            return setcookie($name, '', mktime() - 43200, $path, $domain);
        }
    }
}