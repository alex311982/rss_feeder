<?php

namespace AppBundle\Exception;

class FeederException extends \Exception
{
    const ORM_ERROR_MSG = 'Error connect to database';
    const SERVER_NOT_FOUND_ERROR_MSG = 'Server is not found';
    const SERVER_ERROR_MSG = 'Server error';
}
