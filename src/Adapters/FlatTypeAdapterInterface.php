<?php

/**
 * Developer: alkis_stamos
 * Date: 4/5/2015
 * Time: 6:39 PM
 */

namespace Nuad\Graph\Adapters;

use Nuad\Graph\Core\Property;
use Nuad\Graph\Core\Type;
use Nuad\Graph\Core\Value;

class FlatTypeAdapterInterface implements TypeAdapterInterface
{
    public function map($from, Type $pattern, $name, $scenario)
    {
        if($pattern->value === Property::$_ARRAY_TYPE)
        {
            if(is_array($from))
            {
                return new Value(true,$from);
            }
            else if(is_object($from))
            {
                return new Value(true,(array)$from);
            }
        }
        else if($pattern->value === Property::$_INTEGER_TYPE)
        {
            if(is_int($from))
            {
                return new Value(true,$from);
            }
            else if(is_numeric($from))
            {
                return new Value(true,(int)$from);
            }
        }
        else if($pattern->value === Property::$_BOOLEAN_TYPE)
        {
            if(is_bool($from))
            {
                return new Value(true,$from);
            }
            else if($from === 'true' || $from === 'false' || (int)$from === 0 || (int)$from === 1)
            {
                return new Value(true,filter_var($from,FILTER_VALIDATE_BOOLEAN));
            }
        }
        else if($pattern->value === Property::$_DOUBLE_TYPE)
        {
            if(is_float($from))
            {
                return new Value(true,$from);
            }
            else if(is_numeric($from))
            {
                return new Value(true,(double)$from);
            }
        }
        else if($pattern->value === Property::$_STRING_TYPE)
        {
            if(is_string($from))
            {
                return new Value(true,$from);
            }
            else if(is_numeric($from))
            {
                return new Value(true,(string)$from);
            }
            else if(is_bool($from))
            {
                return new Value(true,$from === true ? 'true' : 'false');
            }
        }
        return null;
    }
} 