<?php

namespace Sda\Millionaires\Request;

class Request
{
    /**
     * @param $param
     * @param string $default
     * @return string
     */
    public function getParamFormGet($param, $default = '')
    {
        if(true === array_key_exists($param, $_GET)){
            return $_GET[$param]; 
        }

        return $default;
    }
    /**
     * 
     * @param String $param
     * @param string $default
     * @return string
     */
    public function getParamsFormPost($param, $default=''){
         if(true === array_key_exists($param, $_POST)){
            return $_POST[$param]; 
        }

        return $default;
    }
}
