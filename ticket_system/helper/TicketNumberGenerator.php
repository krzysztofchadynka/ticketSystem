<?php

namespace app\helper;

use DateTime;

class TicketNumberGenerator
{
    /**
     * @return string
     */
    public static function getNumber()
    {
        $dateTime = new DateTime();
        return $dateTime->getTimestamp() . ' ' . rand();
    }
}