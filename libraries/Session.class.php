<?php

namespace VbertTools;

if (!defined('BASEPATH')) {
    exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

/**
 * Session class
 *
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
class Session {

    /**
     * @var string IP address
     */
    protected $ip;

    /**
     * Constructor
     * @param string $ip IP address (optional)
     */
    public function __construct($ip = '') {
        if (strlen($ip) > 0) {
            $this->ip = $ip;
        }

        if ($this->is_session_started() === FALSE) {
            session_start();
        }
    }

    /**
     * Check is session started
     * @return boolean
     */
    private function is_session_started() {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Get session variable by name
     * @param string $name Name variable
     * @return value variable | boolean
     */
    public function get($name) {
        if (isset($_SESSION[$name])) {
            $result = $_SESSION[$name];
        } else {
            $result = FALSE;
        }
        return $result;
    }

    /**
     * Set session variable
     * @param string $name Name variable
     * @param mixed $value Value variable
     */
    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }

    /**
     * Unset session variable
     * @param string $name Name variable
     */
    public function del($name) {
        unset($_SESSION[$name]);
        unset($name);
    }

    /**
     * Update the current session with new session_id
     * @param boolean $delete_old_session Delete old session or not
     * @return boolean
     */
    public function refresh($delete_old_session = TRUE) {
        if ($delete_old_session) {
            return session_regenerate_id($delete_old_session);
        } else {
            return session_regenerate_id();
        }
    }

    /**
     * Destroys all data in session
     * @return boolean
     */
    public function forget() {
        if (session_id() === '') {
            return FALSE;
        }
        $_SESSION = [];
        return session_destroy();
    }

}
