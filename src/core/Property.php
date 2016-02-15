<?php

/**
 * Developer: alkis_stamos
 * Date: 4/5/2015
 * Time: 8:51 PM
 * Projections
 */

namespace Nuad\Graph;
/**
 * Metadata class to represent a single property of a graph object.
 *
 * Class Property
 * @package Nuad\Graph
 */
class Property //TODO: maybe refactor as trait to accept map?
{
    /**
     * Formats the property as important. Important properties must exist in the target payload and must have a valid
     * value. In any other case the graph will crash throwing an exception.
     *
     * @deprecated Use the Type's importance methods instead
     * @var string
     */
    public static $_IMPORTANT  = 'I';
    /**
     * Formats the property as required. Required properties must exist in the payload the graph engine will map them
     * even if their value is invalid.
     *
     * @deprecated Use the Type's importance methods instead
     * @var string
     */
    public static $_REQUIRED   = 'R';
    /**
     * Formats the property as optional. Optional properties are not required in the payload. The property importance
     * defaults to optional meaning that the engine will assign an empty value to the property or the default value
     * passed by the constructor
     *
     * @deprecated Use the Type's importance methods instead
     * @var string
     */
    public static $_OPTIONAL   = 'O';
    /**
     * The type of the property can either be complex (for objects/lists of objects) or flat for simple types.
     *
     * @var Type
     */
    public $type;
    /**
     * Contains the importance of the object. The value takes one of the static constants of the object.
     *
     * @var string
     */
    public $importance;
    /**
     * Expected property name in the payload. For example a property named email may be bound to a property named
     * e_mail on a payload.
     *
     * @deprecated Use the Type's expected property for the array syntax
     * @var array
     */
    public $expected;
    /**
     * A default value for the property in case it is not found in the payload. If the property is found in the payload
     * the default value will be overridden.
     *
     * @deprecated Use the Type's default property for the array syntax
     * @var null|mixed
     */
    public $default;

    /**
     * Creates an empty property with the given graph Type
     *
     * @param Type $type
     */
    protected final function __construct(Type $type)
    {
        $this->type = $type;
        $this->importance = self::$_OPTIONAL;
        $this->expected = array();
        $this->default = null;
    }

    /**
     * Initializes a property as complex. For complex objects a default graph object must be passed to the types
     * initialization. Shortcut for Type::object when the properties are defined on an array.
     *
     * @deprecated Use the array syntax instead
     * @param Type $type The graph Type of the property
     * @return Property
     */
    public static function complex(Type $type)
    {
        return new self($type);
    }

    /**
     * Initializes a property as flat. The type must passed in order to invoke the constructor. Shortcut for Type:String
     * or Type:Integer etc
     *
     * @deprecated Use the array syntax instead
     * @param Type $type
     * @return Property
     */
    public static function flat(Type $type)
    {
        return new self($type);
    }

    /**
     * Sets the property as important. See the classes $_Important const comments for more info
     *
     * @return $this
     */
    public function important()
    {
        $this->importance = self::$_IMPORTANT;
        return $this;
    }

    /**
     * Sets the property as optional. See the classes $_Optional const comments for more info
     *
     * @return $this
     */
    public function optional()
    {
        $this->importance = self::$_OPTIONAL;
        return $this;
    }

    /**
     * Sets the property as required. See the classes $_Required const comments for more info
     *
     * @return $this
     */
    public function required()
    {
        $this->importance = self::$_REQUIRED;
        return $this;
    }

    /**
     * Sets the default value for the property. If no data are found in the payload to map this property the system will
     * use the default property where defined.
     *
     * @param mixed $default
     * @return $this
     */
    public function defaultVal($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * An array of strings define where the value should be found in the data payload if not by the name mentioned in
     * the graph metadata. The system will search for names by index in the array provided so and will use the first
     * one found.
     *
     * @param array $expected
     * @return $this
     */
    public function expected(Array $expected)
    {
        foreach($expected as $var)
        {
            if(is_string($var))
            {
                $this->expected[] = $var;
            }
        }
        return $this;
    }
} 