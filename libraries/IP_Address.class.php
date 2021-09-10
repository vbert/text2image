<?php

namespace VbertTools;

if (!defined('BASEPATH')) {
    exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

/**
 * IP_Address class
 *
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
class IP_Address {

    /**
     * @var string IP address
     */
    protected $ip;

    /**
     * Constructor
     */
    public function __construct() {
        $this->ip = $this->set();
    }

    /**
     * Get IP address
     * @return string
     */
    public function get() {
        return $this->ip;
    }

    /**
     * Set IP address
     * @return string
     */
    public function set() {
        $ip_src = array(
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        );

        $server = filter_input_array(INPUT_SERVER);

        foreach ($ip_src as $key) {
            if (array_key_exists($key, $server) === TRUE) {
                return $this->validate(filter_input(INPUT_SERVER, $key));
            }
        }
    }

    /**
     * Validate IP address
     * @param string $ip_address
     * @return string|boolean
     */
    public function validate($ip_address) {
        $ip_debug = '';
        foreach (explode(',', $ip_address) as $_ip) {
            $ip = trim($_ip);
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) !== FALSE) {
                $ip_debug .= $ip . '|';
                $result = $ip;
            } else {
                $result = FALSE;
            }
        }
        return $result;
    }

}
