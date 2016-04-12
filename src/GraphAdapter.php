<?php

/**
 * Developer: alkis_stamos
 * Date: 4/5/2015
 * Time: 8:49 PM
 */

namespace Nuad\Graph;
/**
 * The main mapping functionality is within this trait. Started as abstract class but with the trait nature it seems
 * easier to override methods of the main mapping functionality. A thing to consider is that when using inheritance
 * the child graphable object must also use this trait in order to call the methods on its own.
 *
 * Trait GraphAdapter
 * @package Nuad\Graph
 */
trait GraphAdapter
{
    /**
     * Implements the create method of the graphable interface to keep the main entities from implementing the same
     * create method over and over again. NOTICE: the method will use reflection to generate an instance, in order to
     * keep things lighter the graph objects should implement this method themselves.
     *
     * @param bool|false $wReflection If passed as false the mapping method will not use the constructor
     * @return $this The fully mapped graph object
     */
    public static function create($wReflection=false)
    {
        $reflect = new \ReflectionClass(__CLASS__);
        return !$wReflection ? $reflect->newInstanceWithoutConstructor() : $reflect;
    }

    /**
     * Injects the data to the object without having to invoke the create method outside of the trait. The method is
     * basically a shortcut to create instance in one command. If the create method is not overridden the method will
     * try to invoke the entity's constructor with the data.
     *
     * @param array $data The data to be injected in the graph object
     * @param string $scenario String to passed through Type's callbacks to assist on the mapping case
     * @return $this The fully mapped object
     * @throws GraphTypeException
     */
    public static function inject(Array $data, $scenario=null)
    {
        $obj = self::create(true);
        $reflect = null;
        if($obj instanceof \ReflectionClass)
        {
            $reflect = $obj;
            $obj = $reflect->newInstanceWithoutConstructor();
        }
        else if($obj instanceof Graphable)
        {
            $reflect = new \ReflectionClass(__CLASS__);
        }
        if($obj instanceof Graphable && $reflect instanceof \ReflectionClass)
        {
            $graph = $obj->graph();
            $properties = array();
            foreach($graph->properties as $name=>$property)
            {
                $valInject = self::mapInternalProperty($data,$name,$property,$scenario);
                if($valInject !== null)
                {
                    $properties[$name] = $valInject;
                }
            }
            if(null !== ($constructor = $reflect->getConstructor()))
            {
                $params = $constructor->getParameters();
                $inject = array();
                foreach($params as $index=>$param)
                {
                    if(array_key_exists($param->name,$properties))
                    {
                        $inject[$index] = $properties[$param->name];
                        continue;
                    }
                    $val = null;
                    if($param->isDefaultValueAvailable())
                    {
                        $val = $param->getDefaultValue();
                    }
                    $inject[$index] = $val;
                }
                $obj = $reflect->newInstanceArgs($inject);
            }
            else
            {
                foreach($properties as $name=>$value)
                {
                    $obj->{$name} = $value;
                }
            }
            $graph->complete($obj, $scenario, $data);
            $obj->finalize($scenario, $data);
        }
        return $obj;
    }

    /**
     * Method to be used when mapping with already created graph objects. The method will require the empty entity, a
     * reflection of that entity and the data to map. The purpose of this method is to not let the trait decide when
     * to create new entities by reflection.
     *
     * The scenario param is passed to assist for different mapping cases when using callbacks on properties. The
     * scenario value along with the data and the found name will be passed to the callback.
     *
     * @param Graphable $obj The empty instance of the graph object
     * @param array $data The data to be mapped to the graph object
     * @param string $scenario String to passed through Type's callbacks to assist on the mapping case
     * @return $this The fully mapped object
     * @throws GraphTypeException
     */
    public static function injectWithInstance(Graphable $obj, Array $data, $scenario=null)
    {
        $graph = $obj->graph();
        foreach($graph->properties as $name=>$property)
        {
            $valInject = self::mapInternalProperty($data,$name,$property,$scenario);
            if($valInject !== null)
            {
                $obj->{$name} = $valInject;
            }
        }
        $graph->complete($obj, $scenario, $data);
        $obj->finalize($scenario, $data);
        return $obj;
    }

    /**
     * The simplest way to map a graph object. The method will just call the create method of the entity and will try
     * to map the data provided based on the graph metadata
     *
     * The scenario param is passed to assist for different mapping cases when using callbacks on properties. The
     * scenario value along with the data and the found name will be passed to the callback.
     *
     * @param array $data The data to be mapped
     * @param string $scenario String to passed through Type's callbacks to assist on the mapping case
     * @return $this The fully mapped graph object
     * @throws GraphTypeException
     */
    public static function map(Array $data, $scenario=null)
    {
        $obj = self::create();
        if($obj instanceof Graphable)
        {
            $graph = $obj->graph();
            foreach($graph->properties as $name=>$property)
            {
                $obj->{$name} = self::mapInternalProperty($data,$name,$property,$scenario);
            }
            $graph->complete($obj, $scenario, $data);
            $obj->finalize($scenario, $data);
        }
        return $obj;
    }

    /**
     * The method is used to map data to already created objects. The method will fill only the empty properties of the
     * entity and will ignore properties that already have values. For example when creating a DTO from one database but
     * need to pass values from another database system without creating a new instance.
     *
     * The scenario param is passed to assist for different mapping cases when using callbacks on properties. The
     * scenario value along with the data and the found name will be passed to the callback.
     *
     * @param array $data The data to be mapped to the empty values of the object
     * @param string $scenario String to passed through Type's callbacks to assist on the mapping case
     * @return $this The fully mapped graph object
     */
    public function mapEmpty(Array $data, $scenario=null)
    {
        if($this instanceof Graphable)
        {
            $graph = $this->graph();
            foreach($graph->properties as $name=>$property)
            {
                try
                {
                    if($this->{$name} === null)
                    {
                        $this->{$name} = self::mapInternalProperty($data,$name,$property,$scenario);
                        continue;
                    }
                }
                catch(\Exception $e)
                {
                    continue;
                }
            }
            $graph->complete($this, $scenario, $data);
            $this->finalize($scenario, $data);
        }
        return $this;
    }

    /**
     * Maps a single property of the object. The property name must match the property set in the graph method of the
     * object. NOTICE: the method will fail on flat type data (int, string, bool etc) those properties should be mapped
     * the traditional way as $this->property=value
     *
     * The scenario param is passed to assist for different mapping cases when using callbacks on properties. The
     * scenario value along with the data and the found name will be passed to the callback.
     *
     * @param array $data The data to map to the property
     * @param string $propertyName The property name of the object
     * @param string $scenario String to passed through Type's callbacks to assist on the mapping case
     * @return $this The fully mapped graph object
     * @throws GraphTypeException
     */
    public function mapProperty(Array $data,$propertyName,$scenario=null)
    {
        if($this instanceof Graphable)
        {
            $entity = $this->graph();
            if(!array_key_exists($propertyName,$entity->properties))
            {
                throw new GraphTypeException('Property: '.$propertyName.' was not found on graph');
            }
            $this->{$propertyName} = self::mapInternalProperty(array($propertyName => $data),$propertyName,$entity->properties[$propertyName],$scenario);
        }
        return $this;
    }

    /**
     * Internal method used to map properties to its values the method will take each property and though the graph
     * metadata will try to map the passed data array to the entity's property
     *
     * The scenario param is passed to assist for different mapping cases when using callbacks on properties. The
     * scenario value along with the data and the found name will be passed to the callback.
     *
     * @param array $data The data to be mapped to the property
     * @param string $name The name of the property
     * @param Type $property The graph type of the property
     * @param string $scenario String to passed through Type's callbacks to assist on the mapping case
     * @return null|mixed The method will allow null on optional properties
     * @throws GraphTypeException
     */
    private static function mapInternalProperty(Array $data, $name, Type $property, $scenario=null)
    {
        $val = $property->match($name,$data,$scenario);
        $injectable = null;
        if($val === null)
        {
            if($property->importance === Type::$_IMPORTANT)
            {
                throw new GraphTypeException('Important property: '.$name.' found no match in dataset');
            }
        }
        else if($val === false)
        {
            if($property->importance === Type::$_IMPORTANT || $property->importance === Type::$_REQUIRED)
            {
                throw new GraphTypeException('Required or important property: '.$name.' found no match in dataset');
            }
        }
        else if($val instanceof Value)
        {
            $injectable = $val->value;
        }
        else
        {
            throw new GraphTypeException('Unknown value:'.$val.' for property: '.$name.' on object: '.__CLASS__);
        }
        return $injectable;
    }

    /**
     * Will create an empty object for mapping. Under consideration to only use this method when trying to map empty so
     * the mapEmpty method will only check for null values to bind
     *
     * @return $this
     */
    public static function createEmpty()
    {
        $obj = self::create();
        $vars = get_object_vars($obj);
        foreach($vars as $prop=>$var)
        {
            $obj->{$prop} = null;
        }
        return $obj;
    }

    /**
     * Method implemented by the trait to replicate the entity's complete method. The method signature does nothing but
     * being called. Is here for any Graphable object to override and provide a simple way to implement a map finalize
     * method. The method provides access to the scenario and the data (the instance being the object itself).
     *
     * @param string $scenario
     * @param array $data
     */
    public function finalize($scenario, array $data){}
}
