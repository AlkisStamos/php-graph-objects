<?php

namespace Nuad\Graph\Test;


class Util
{
    public static function arrays_are_similar($expected, $actual)
    {
        if (count(array_diff_assoc($expected, $actual)))
        {
            return false;
        }
        foreach($expected as $k => $v)
        {
            if ($v !== $actual[$k])
            {
                return false;
            }
        }
        return true;
    }

    public static function loadData($key)
    {
        $data = require 'mock/data.php';
        return $data[$key];
    }
}