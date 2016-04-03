<?php

/**
 * Developer: alkis_stamos
 * Date: 4/5/2015
 * Time: 6:41 PM
 */

namespace Nuad\Graph;

interface TypeAdapter
{
    /**
     * All type adapters must map the data to a property using this method. The method should use the patter type and
     * map the from payload to the property.
     *
     * @param mixed $from The incoming data
     * @param Type $pattern The property type
     * @param string $name
     * @param mixed $scenario
     * @return mixed
     */
    public function map($from, Type $pattern, $name, $scenario);
}