<?php

/**
 * Developer: alkis_stamos
 * Date: 4/10/2015
 * Time: 9:39 AM
 */

namespace Nuad\Graph;

class Value
{
    public $found;
    public $value;

    public function __construct($found, $value)
    {
        $this->found = $found;
        $this->value = $value;
    }
} 