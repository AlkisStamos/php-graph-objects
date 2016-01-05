<?php

/**
 * Developer: alkis_stamos
 * Date: 4/5/2015
 * Time: 6:39 PM
 */

namespace Nuad\Graph;
/**
 * Class CollectionAdapter
 * @package Nuad\Graph
 */
class CollectionAdapter implements TypeAdapter
{
    /**
     * Maps an array of objects to the graphable object. The method uses the object adapter for each entry.
     * When a collection type is defined on a graph method of the graphable object, must pass an instance of
     * the type of the objects in the collection. The method uses that instance to clone as many objects as
     * it must.
     *
     * @param $from
     * @param Type $pattern
     * @return Value|null
     * @throws GraphTypeException
     */
    public function map($from, Type $pattern)
    {
        if(!array_key_exists(0,$pattern->value))
        {
            throw new GraphTypeException('Graph collection did not define a type');
        }
        $graph = clone $pattern->value[0];
        if($graph instanceof Graphable)
        {
            $collection = array();
            foreach($from as $value)
            {
                $collection[] = $graph->map($value);
                $graph = clone $pattern->value[0];
            }
            return new Value(true,$collection);
        }
        return null;
    }
} 