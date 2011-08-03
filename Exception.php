<?php

namespace GOC\WorkflowBundle;

class Exception extends \Exception
{
    public static function illegalDefinitionObject($object)
    {
        return new self('Given object is not an instance of \GOC\WorkflowBundle\WorkflowDefinition: ' . get_class($object));
    }

    public static function illegalDefinitionString($string)
    {
        return new self('Illegal workflow definition string: ' . $string);
    }
}
