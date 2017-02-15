<?php

namespace Sda\Millionaires\Session;

/**
 * Class Session
 * @package Sda\Millionaires\Session
 */
class Session
{

    const PREFIX = 'AppMillionaires_';
    

    public function __construct()
    {
        $this->start();
    }

    public function put($key, $value)
    {
        $_SESSION[self::PREFIX . $key] = $value;
    }
    
    public function get($key, $default = null)
    {
        return  (true === array_key_exists(self::PREFIX . $key, $_SESSION)) ?
            $_SESSION[self::PREFIX . $key] : $default;
    }

    public function restart()
    {
        $_SESSION = [];
    }

    public function kill()
    {
        session_destroy();
    }

    public function start()
    {
        session_start();
    }
}