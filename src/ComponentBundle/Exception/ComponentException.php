<?php

namespace ComponentBundle\Exception;

class ComponentException extends \Exception
{
    const ORM_ERROR_MSG = 'Error while getting data for component %component_name%';
    const NOT_EXIST_COMPONENT_CLASS = 'There is not component %component_name% within services';

    static function formatMsg(array $values, string $subject): string
    {
        return str_replace(array_keys($values), array_values($values), $subject);
    }
}
