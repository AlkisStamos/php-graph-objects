<?php

/**
 * Developer: alkis_stamos
 * Date: 4/5/2015
 * Time: 6:40 PM
 */

namespace Nuad\Graph;

class ObjectAdapter implements TypeAdapter
{
    public function map($from, Type $pattern)
    {
        return new Value(true,$pattern->value->map($from));
    }
} 