<?php

/**
 * Developer: alkis_stamos
 * Date: 4/5/2015
 * Time: 8:48 PM
 */

namespace Nuad\Graph;
/**
 * Main class to contain all the name/type metadata of a graph object.
 *
 * Class Entity
 * @package Nuad\Graph
 */
class Entity
{
    /**
     * Property holding variations of the name of the current entity. For example a class User may be mapped
     * from a tag 'User','user' or 'Person' (which will be the values of the names array).
     *
     * @var string[]
     */
    public $names;
    /**
     * A collection of types defining each property of the entity. The Graph entities are written before PHP7 so
     * there are no type definitions or type safety. Defining properties with their names and their expected type
     * values gives a basic type safety for object mapping.
     *
     * @var Type[]
     */
    public $properties;

    /**
     * Constructor of the entity graph. Defined private so that the class can only be instantiated through the
     * static method graph
     *
     * @param $names
     */
    private final function __construct($names)
    {
        $this->names = $names;
        $this->properties = array();
    }

    /**
     * Static constructor of the class. The entity class can only be instantiated through this method. Giving a nice
     * structure of how the graph entities are defining their properties.
     *
     * @param string[] $names
     * @return Entity
     */
    public static function graph(Array $names)
    {
        return new self($names);
    }

    /**
     * Setter for the properties property. Will define every property of the current object with an assoc array as
     * $properties['name'] = Type.
     *
     * @param Type[] $properties
     * @return $this
     */
    public function properties(Array $properties)
    {
        foreach ($properties as $key => $property)
        {
            if ($property instanceof Type)
            {
                $this->properties[$key] = $property;
            }
        }
        return $this;
    }

    /**
     * Used by derived classes to extend a parent graphable entity. The $names array must contain the names of the
     * derived entity which will override the names of the parent entity. The derived properties must be set by the
     * normal properties method of the Entity object.
     *
     * @param string[] $names
     * @return $this
     */
    public function extend(Array $names)
    {
        $this->names = $names;
        return $this;
    }
} 