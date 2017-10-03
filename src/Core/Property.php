<?php

/**
 * Developer: alkis_stamos
 * Date: 4/5/2015
 * Time: 8:51 PM
 * Projections
 */

namespace Nuad\Graph\Core;

/**
 * Metadata class to represent a single property of a graph object.
 *
 * Class Property
 * @package Nuad\Graph
 */
class Property
{
    /**
     * Const to determine if the Property type is string
     *
     * @var string
     */
    public static $_STRING_TYPE = 'S';
    /**
     * Const to determine if the Property type is integer
     *
     * @var string
     */
    public static $_INTEGER_TYPE = 'I';
    /**
     * Const to determine if the Property type is boolean
     *
     * @var string
     */
    public static $_BOOLEAN_TYPE = 'B';
    /**
     * Const to determine if the Property type is array
     *
     * @var string
     */
    public static $_ARRAY_TYPE = 'A';
    /**
     * Const to determine if the Property type is float or double
     *
     * @var string
     */
    public static $_DOUBLE_TYPE = 'D';
    /**
     * The type of the property can either be complex (for objects/lists of objects) or flat for simple types.
     *
     * @var Type
     */
    public $type;

    /**
     * Creates an empty property with the given graph Type
     *
     * @param Type $type
     */
    protected final function __construct(Type $type)
    {
        $this->type = $type;
    }
} 