<?php
/**
 * Developer: alkis_stamos
 * Date: 1/10/2017
 * Time: 8:49 PM
 */

namespace Nuad\Graph;

/**
 * Factory to generate reflections, instances and object graphs. The factory implements an internal cache providing
 * performance on repeated hydrations of the same object.
 *
 * Class GraphFactory
 * @package Nuad\Graph
 */
class GraphFactory
{
    /**
     * Local array to hold reflection class instances on runtime
     *
     * @var \ReflectionClass[]
     */
    private static $reflections;
    /**
     * Local array to hold Graphable copies on runtime
     *
     * @var Graphable[]
     */
    private static $instances;
    /**
     * Local array to hold copies of Graphable metadata on runtime
     *
     * @var Entity[]
     */
    private static $graphs;

    /**
     * Creates an object of a reflection instance from a class name. If the $wReflection parameter passed as false the
     * method will not use a constructor
     *
     * @param $class
     * @param bool $wReflection
     * @return Graphable|null|object|\ReflectionClass
     */
    public static function create($class, $wReflection = false)
    {
        $instance = !$wReflection ? self::getInstance($class) : null;
        if ($instance === null) {
            $reflection = self::getReflection(__CLASS__);
            if ($reflection === null) {
                $reflection = new \ReflectionClass($class);
                self::setReflection($class, $reflection);
            }
            $instance = !$wReflection ? $reflection->newInstanceWithoutConstructor() : $reflection;
            if (!$wReflection) {
                self::setInstance($class, $instance);
            }
        }
        return $instance;
    }

    /**
     * Returns a copy of a stored Graphable instance
     *
     * @param $class
     * @return Graphable|null
     */
    public static function getInstance($class)
    {
        return isset(self::$instances[$class]) ? clone self::$instances[$class] : null;
    }

    /**
     * Returns a stored reflection of a class
     *
     * @param $class
     * @return null|\ReflectionClass
     */
    public static function getReflection($class)
    {
        return isset(self::$reflections[$class]) ? self::$reflections[$class] : null;
    }

    /**
     * Sets the ReflectionClass in the local repository
     *
     * @param $class
     * @param \ReflectionClass $reflection
     */
    public static function setReflection($class, \ReflectionClass $reflection)
    {
        self::$reflections[$class] = $reflection;
    }

    /**
     * Sets a Graphable instance in the local repository
     *
     * @param $class
     * @param Graphable|object $instance
     */
    public static function setInstance($class, Graphable $instance)
    {
        self::$instances[$class] = clone $instance;
    }

    /**
     * Returns the instances graph metadata
     *
     * @param Graphable $instance
     * @return Entity|null
     */
    public static function getGraphMetadata(Graphable $instance)
    {
        $class = get_class($instance);
        $graph = self::getGraph($class);
        if ($graph === null) {
            $graph = $instance->graph();
            self::setGraph($class, $graph);
        }
        return self::getGraph($class);
    }

    /**
     * Returns the Graphable metadata of the class
     *
     * @param $class
     * @return Entity|null
     */
    public static function getGraph($class)
    {
        return isset(self::$graphs[$class]) ? self::$graphs[$class] : null;
    }

    /**
     * Sets the Graphable metadata of the class in the local repository
     *
     * @param $class
     * @param Entity $graph
     */
    public static function setGraph($class, Entity $graph)
    {
        self::$graphs[$class] = $graph;
    }

    /**
     * Utility method to clear the cache arrays
     */
    public static function clear()
    {
        self::$instances = [];
        self::$graphs = [];
        self::$reflections = [];
    }
}
