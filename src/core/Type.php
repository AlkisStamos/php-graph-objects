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
     * @var Entity | Array | Entity[] | GraphAdapter | GraphAdapter[]
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
     * @var callable
     */
    private $mapCallback;

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
     * Method to parse the incoming payload data array and will try to find a key matching the passed property name
     * (or the expected array). If found the method will apply the defined adapter to the data to map the data to the
     * property value.
     *
     * @param $name
     * @param array $payload
     * @param string $scenario String to passed through Type's callbacks to assist on the mapping case
     * @return bool | null
     */
    public function match($name, Array $payload, $scenario)
    {
        $matched = false;
        foreach($payload as $key=>$val)
        {
            if($key == $name)
            {
                $callback = null;
                if($this->mapCallback !== null)
                {
                    $callback = self::runMapCallback($this->mapCallback,$val,$name,$scenario);
                }
                $matched = $callback === null ? $this->adapter->map($val,$this) : new Value(true,$callback);
                break;
            }
        }
        if($matched === false)
        {
            foreach($this->expected as $expected=>$checked)
            {
                if(!$checked)
                {
                    $this->expected[$expected] = true;
                    $matched = $this->match($expected,$payload,$scenario);
                    break;
                }
            }
        }
        return $matched;
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