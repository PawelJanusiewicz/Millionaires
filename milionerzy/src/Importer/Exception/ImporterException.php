<?php

namespace Sda\Millionaires\Importer\Exception;

class ImporterException extends \Exception
{
    /**
     * ImporterException constructor.
     * @param string $message
     * @param int $code
     * @param null $previous
     */
    public function __construct($message = "", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}