<?php
/**
 * Copyright: 2019 - Session
 *
 * Licence: MIT
 *
 * The cookie controller class
 *
 * @summary Session class
 * @author Mohammed Odunayo <vickyprogrammer@gmail.com>
 *
 * Created at     : 2019-09-01 14:48:34
 * Last modified  : 2019-09-01 16:51:46
 */

namespace Framework\Engine {

    class Session
    {

        /**
         * Class constructor
         */
        public function __construct()
        {
            session_start();
        }

        /**
         * Get a session value
         *
         * @param string $name
         * @param null $default
         * @return mixed
         */
        final public function get(string $name, $default = null)
        {
            if (isset($_SESSION[$name])) {
                return $_SESSION[$name];
            }
            return $default;
        }

        /**
         * Get all session in an associative array
         *
         * @return array
         */
        final public function getAll(): array
        {
            return $_SESSION;
        }

        /**
         * Set a session variable
         *
         * @param string $name
         * @param mixed $value
         * @return void
         */
        final public function set(string $name, $value): void
        {
            $_SESSION[$name] = $value;
        }

        /**
         * Remove a session variable
         *
         * @param string $name
         * @return void
         */
        final public function remove(string $name): void
        {
            unset($_SESSION[$name]);
        }

        /**
         * Destroy the entire session
         *
         * @return void
         */
        final public function destroy(): void
        {
            session_destroy();
        }

        /**
         * Start a session
         *
         * @return void
         */
        final public function start(): void
        {
            session_start();
        }

        /**
         * Check for available session and return the value, or redirect to the specified redirectTo location, or will return false if the redirectTo is not set
         *
         * @param string $name
         * @param string $redirectTo
         * @return mixed
         */
        final public function authUserSession(string $name, string $redirectTo = null)
        {
            $session = $this->get($name, false);

            if (!$session) {
                if ($redirectTo != null) {
                    header("Location: $redirectTo");
                    die();
                }
            }

            return $session;
        }
    }
}