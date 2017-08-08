<?php

namespace app\enum;

class Enum
{
    /**
     * @return array
     */
    public static function getList()
    {
        $reflectionClass = new \ReflectionClass(get_called_class());
        return $reflectionClass->getConstants();
    }
}