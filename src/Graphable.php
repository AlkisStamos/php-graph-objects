<?php

/**
 * Developer: alkis_stamos
 * Date: 4/5/2015
 * Time: 8:49 PM
 */

namespace Nuad\Graph;
/**
 * All graph objects must implement this interface in order to be used. Also every derived or contained object must also
 * be graphable in order to be graphed along with the main object.
 *
 * Interface Graphable
 * @package Nuad\Graph
 */
interface Graphable
{
    /**
     * This method should return an empty instance of the graphable object. Either by reflection methods or by default
     * values through the objects constructor.
     *
     * @return $this The empty graph object instance
     */
    public static function create();

    /**
     * Must return the main metadata of the entity in order to be mapped using a standard format best shown at examples.
     *
     * @return Entity The entity metadata to be used on mapping
     */
    public function graph();

    /**
     * Base method used to map the array of data to the graphable object. The main purpose of the method is to create
     * an empty object that implements the graphable and to map the data to its properties using the graph metadata.
     *
     * @param array $data The assoc array to be mapped on the graph object
     * @return $this The fully mapped object
     */
    public static function map(Array $data);

    /**
     * Method that replicates the entity's complete method. The method provides access to the scenario and the data
     * (the instance being the object itself). It should be called by hydrators as soon as the object is mapped.
     *
     * @param string $scenario
     * @param array $data
     * @return void
     */
    public function finalize($scenario, array $data);
} 