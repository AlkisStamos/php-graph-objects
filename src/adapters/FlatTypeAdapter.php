<?php

/**
 * Developer: alkis_stamos
 * Date: 4/5/2015
 * Time: 6:39 PM
 */

namespace Nuad\Graph;

class FlatTypeAdapter implements TypeAdapter
{
    public function map($from, Type $pattern)
    {
        if(is_array($pattern->value) && is_array($from))
        {
            return new Value(true,$from);
        }
        if(is_int($pattern->value))
        {
            if(is_int($from))
            {
                return new Value(true,$from);
            }
            else if(is_string($from))
            {
                return new Value(true,(int)$from);
            }
        }
        else if(is_bool($pattern->value))
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
        else if(is_float($pattern->value))
        {
            if(is_float($from))
            {
                return new Value(true,$from);
            }
            else if(is_string($from))
            {
                return new Value(true,(double)$from);
            }
        }
        else if(is_string($pattern->value) && is_string($from))
        {
            return new Value(true,$from);
        }
        return null;
    }

    private static function isSimpleType($type)
    {
        return $type === 'string'
        || $type === 'boolean' || $type === 'bool'
        || $type === 'integer' || $type === 'int'
        || $type === 'float' || $type === 'array' || $type === 'object';
    }

    private static function isFlatType($type)
    {
        return $type === 'NULL'
        || $type === 'string'
        || $type === 'boolean' || $type === 'bool'
        || $type === 'integer' || $type === 'int'
        || $type === 'double';
    }
} 