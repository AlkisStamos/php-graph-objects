<?php

/**
 * Developer: alkis_stamos
 * Date: 4/5/2015
 * Time: 6:30 PM
 */

namespace Nuad\Graph;
/**
 * Metadata class that represents the type of a graph object's property. The class contains many methods that apply to
 * the property instead of strictly the type so that it would be clearer and easier to define the graph entity.
 *
 * Class Type
 * @package Nuad\Graph
 */
class Type
{
    /**
     * Formats the property as important. Important properties must exist in the target payload and must have a valid
     * value. In any other case the graph will crash throwing an exception.
     *
     * @var string
     */
    public static $_IMPORTANT  = 'I';
    /**
     * Formats the property as required. Required properties must exist in the payload the graph engine will map them
     * even if their value is invalid.
     *
     * @var string
     */
    public static $_REQUIRED   = 'R';
    /**
     * Formats the property as optional. Optional properties are not required in the payload. The property importance
     * defaults to optional meaning that the engine will assign an empty value to the property or the default value
     * passed by the constructor
     *
     * @var string
     */
    public static $_OPTIONAL   = 'O';
    /**
     * The importance of the property that the Type is bound to
     *
     * @var string
     */
    public $importance;
    /**
     * Expected property name in the payload. For example a property named email may be bound to a property named
     * e_mail on a payload.
     *
     * @var array
     */
    public $expected;
    /**
     * A default value for the property in case it is not found in the payload. If the property is found in the payload
     * the default value will be overridden.
     *
     * @var null|mixed
     */
    public $default;
    /**
     * A value that represents the type of the property. For example a property of type int will have the value of zero.
     * Its main cause is to provide a way to map entities or arrays of entities of a certain object type.
     *
     * @var Entity | array | Entity[] | GraphAdapter | GraphAdapter[]
     */
    public $value;
    /**
     * The graph adapter which will be responsible to map the data to the property. For each defined property the graph
     * object will call the defined adapters map method to map the data.
     *
     * @var TypeAdapter
     */
    public $adapter;
    /**
     * The handler callback of the property. The handler callback will be called before applying the data to the
     * property and its return value will be mapped instead.
     *
     * @var callable
     */
    private $mapCallback;
    /**
     * Excepted property names in the payload. The difference is that the bindings names will override the property
     * names and will be chosen first.
     *
     * @var array
     */
    private $bindings;

    /**
     * Private and final constructor. The type object can only be instantiated though its static methods in order to
     * provide correct initialization.
     *
     * @param $value
     * @param TypeAdapter $adapter
     */
    protected final function __construct($value, TypeAdapter $adapter)
    {
        $this->value = $value;
        $this->adapter = $adapter;
        $this->importance = self::$_OPTIONAL;
        $this->expected = array();
        $this->bindings = array();
        $this->default = null;
        $this->mapCallback = null;
    }

    /**
     * Constructs a flat (string, boolean etc) type adapter. If the type of the incoming data are flat but unknown type
     * this method should be used. It will instantiate the type as string and bound the incoming value as such.
     *
     * @return Type
     */
    public static function flat()
    {
        return new self('', new FlatTypeAdapter());
    }

    /**
     * Constructs a flat string adapter. Same function as the flat() method. For strict string typed properties use
     * this method. This way the type will be clear in the entity's definition.
     *
     * @return Type
     */
    public static function String()
    {
        return new self('', new FlatTypeAdapter());
    }

    /**
     * Constructs the type with a flat boolean adapter
     *
     * @return Type
     */
    public static function Boolean()
    {
        return new self(false, new FlatTypeAdapter());
    }

    /**
     * Constructs the type with a flat float adapter
     *
     * @return Type
     */
    public static function Float()
    {
        return new self(0.0, new FlatTypeAdapter());
    }

    /**
     * Constructs the type with a flat double adapter (basically its the same as float).
     *
     * @return Type
     */
    public static function Double()
    {
        return new self(0.0, new FlatTypeAdapter());
    }

    /**
     * Constructs the type with a flat integer adapter
     *
     * @return Type
     */
    public static function Integer()
    {
        return new self(1, new FlatTypeAdapter());
    }

    /**
     * Constructs the type with a flat array adapter. This means that the outgoing property will be a simple array
     * containing indexes=>values. This way there can be a separation between simple arrays and arrays containing
     * objects.
     *
     * @return Type
     */
    public static function FlatArray()
    {
        return new self(array(), new FlatTypeAdapter());
    }

    /**
     * Constructs the type with an object adapter. The adapter will use the provided object in order to map the data.
     * Notice that all objects defined in a graph entity must be graphable as well.
     *
     * @param Graphable $obj
     * @return Type
     */
    public static function Object(Graphable $obj)
    {
        return new self($obj, new ObjectAdapter());
    }

    /**
     * Constructs the type with a collection adapter. The collection defines an array of objects. The adapter will use
     * the provided object in an array and will map all the incoming data while pushing them in the same array.
     *
     * @param Graphable $obj
     * @return Type
     */
    public static function Collection(Graphable $obj)
    {
        return new self(array($obj), new CollectionAdapter());
    }

    /**
     * Sets the property that is defined by the type as important. The method has been moved from the property class in
     * order to provide a more easy and clear way to define an entity.
     *
     * @return $this
     */
    public function important()
    {
        $this->importance = self::$_IMPORTANT;
        return $this;
    }

    /**
     * Sets the property that is defined by the type as optional. The method has been moved from the property class in
     * order to provide a more easy and clear way to define an entity.
     *
     * @return $this
     */
    public function optional()
    {
        $this->importance = self::$_OPTIONAL;
        return $this;
    }

    /**
     * Sets the property that is defined by the type as required. The method has been moved from the property class in
     * order to provide a more easy and clear way to define an entity.
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
     * use the default property where defined. The method has been moved from the property class in order to provide a
     * more easy and clear way to define an entity.
     *
     * @param $default
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
     * one found. The method has been moved from the property class in order to provide a more easy and clear way to
     * define an entity.
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
                $this->expected[$var] = false;
            }
        }
        return $this;
    }

    /**
     * An array of strings define where the value should be found in the data payload. The system will first try to
     * match indexes in the payload with the bindings names before applying the standard property name search.
     *
     * @param array $bindings
     * @return $this
     */
    public function bindTo(array $bindings)
    {
        $this->bindings = $bindings;
        return $this;
    }

    /**
     * Method to parse the incoming payload data array and will try to find a key matching the passed property name
     * (or the expected array). If found the method will apply the defined adapter to the data to map the data to the
     * property value.
     *
     * @param $name
     * @param array $payload
     * @param string $scenario String to passed through Type's callbacks to assist on the mapping case
     * @return Value | null
     */
    public function match($name, Array $payload, $scenario)
    {
        foreach($this->bindings as $binding)
        {
            $matched = (strpos($binding,'.') !== false) ?
                $this->matchNested(explode('.',$binding),$payload,$scenario,$found) :
                $this->matchValue($binding,$payload,$scenario,$found);
            if($found)
            {
                return $matched;
            }
        }
        $matched = $this->matchValue($name,$payload,$scenario,$found);
        if(!$found)
        {
            foreach($this->expected as $expected=>$checked)
            {
                if(!$checked)
                {
                    $this->expected[$expected] = true;
                    if(strpos($expected,'.') !== false)
                    {
                        $matched = $this->matchNested(explode('.',$expected),$payload,$scenario,$found);
                        break;
                    }
                    else
                    {
                        $matched = $this->matchValue($expected,$payload,$scenario,$found);
                        break;
                    }
                }
            }
            if(!$found && $this->default !== null)
            {
                $matched = new Value(true,$this->default);
            }
        }
        return $matched;
    }

    /**
     * Method that maps return the value to be applied to the current property. The name passed may be the property
     * name or the expected/bindTo name of the property. If exists runs the handler callback of the property.
     *
     * @param $name
     * @param $val
     * @param $scenario
     * @return mixed|Value
     */
    private function map($name, $val, $scenario)
    {
        $callback = null;
        if($this->mapCallback !== null)
        {
            $callback = self::runMapCallback($this->mapCallback,$val,$name,$scenario);
        }
        return $callback === null ? $this->adapter->map($val,$this) : new Value(true,$callback);
    }

    /**
     * Matches the value of the payload to the name provided. If found the method will set the matched reference to true
     * in other case the method will return null and the matched set to false.
     *
     * @param $name
     * @param $payload
     * @param $scenario
     * @param $matched
     * @return mixed|Value|null
     */
    private function matchValue($name, $payload, $scenario, &$matched)
    {
        $matchedValue = null;
        $matched = false;
        $value = self::matchRawValue($name,$payload,$found);
        if($found)
        {
            $matched = true;
            $matchedValue = $this->map($name,$value,$scenario);
        }
        return $matchedValue;
    }

    /**
     * Method that wraps the way a property name is found in the payload. If found the method will set the found
     * reference to true.
     *
     * @param $name
     * @param array $payload
     * @param $found
     * @return null
     */
    private static function matchRawValue($name, array $payload, &$found)
    {
        $found = false;
        if(isset($payload[$name]))
        {
            $found = true;
            return $payload[$name];
        }
        return null;
    }

    /**
     * Method that matches a nested value (using the '.' character in the expected or bind to values). If the value is
     * matched the method will set the matched reference to true.
     *
     * @param array $profile
     * @param array $payload
     * @param $scenario
     * @param $matched
     * @return mixed|Value|null
     */
    private function matchNested(array $profile, array $payload, $scenario, &$matched)
    {
        $matchedValue = null;
        $matched = false;
        $nested = $payload;
        foreach($profile as $profileIndex=>$profileItem)
        {
            $value = self::matchRawValue($profileItem,$nested,$found);
            if($found === false)
            {
                $matched = false;
                return $matchedValue;
            }
            else if(!isset($profile[$profileIndex + 1]))
            {
                $matchedValue = $this->map($profileItem,$value,$scenario);
                $matched = true;
                return $matchedValue;
            }
            else
            {
                $nested = $value;
            }
        }
        return $matchedValue;
    }



    /**
     * Attaches a callback to the property. The callback will be called when the match property has found a valid name
     * in the payload to map the property with. The callback has three parameters. The data found in the payload, the
     * name of the index the data was found in and the scenario. The scenario is passed to assist with different types
     * of mapping
     *
     * @param callable $callable
     * @return $this
     */
    public function handler(callable $callable)
    {
        $this->mapCallback = $callable;
        return $this;
    }

    /**
     * Helper method to run a callback that is a property (on $this)
     *
     * @param callable $callback
     * @param mixed $data
     * @param string $name
     * @param string $scenario
     * @return mixed
     */
    private static function runMapCallback(callable $callback, $data, $name, $scenario)
    {
        return $callback($data,$name,$scenario);
    }
}