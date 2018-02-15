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
        $templateArgs = array_slice($args, 1);
        if (count($templateArgs) === 1 && is_array($templateArgs[0])) {
            $templateArgs = $templateArgs[0];
        }
        parent::__construct(vsprintf($message, $templateArgs));
    }
}
