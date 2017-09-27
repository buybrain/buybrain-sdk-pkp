<?php
namespace Buybrain\Buybrain\Exception;

class Exception extends \Exception
{
    /**
     * @param string $message
     */
    public function __construct($message)
    {
        $args = func_get_args();
        parent::__construct(vsprintf($message, array_slice($args, 1)));
    }
}
