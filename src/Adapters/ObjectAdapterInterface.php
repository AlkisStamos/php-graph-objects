<?php

/**
 * Developer: alkis_stamos
 * Date: 4/5/2015
 * Time: 6:40 PM
 */

namespace Nuad\Graph\Adapters;

use Nuad\Graph\Core\Type;
use Nuad\Graph\Core\Value;

class ObjectAdapterInterface implements TypeAdapterInterface
{
    public function map($from, Type $pattern, $name, $scenario)
    {
        return new Value(true,$pattern->value->map($from));
    }
} 