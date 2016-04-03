<?php
/**
 * Developer: alkis_stamos
 * Date: 3/30/16
 * Time: 12:09 AM
 */

namespace Nuad\Graph;
/**
 * Class MixedTypeAdapter
 * @package Nuad\Graph
 */
class MixedTypeAdapter implements TypeAdapter
{

    /**
     * All type adapters must map the data to a property using this method. The method should use the patter type and
     * map the from payload to the property.
     *
     * @param mixed $from The incoming data
     * @param Type $pattern The property type
     * @param $name
     * @param $scenario
     * @return mixed
     */
    public function map($from, Type $pattern, $name, $scenario)
    {
        return new Value(true,$from);
    }
}