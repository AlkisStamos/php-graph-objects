<?php
/**
 * Created by IntelliJ IDEA.
 * User: smiley
 * Date: 1/5/16
 * Time: 5:51 PM
 */

namespace Nuad\Graph\Example;

use Nuad\Graph\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Type;

class Location implements Graphable
{
    use GraphAdapter;
    /**
     * @var Point
     */
    public $point;
    /**
     * @var string
     */
    public $city;
    /**
     * @var string
     */
    public $country;
    /**
     * @var string
     */
    public $address;

    public function __construct(Point $point=null, $city='', $country='', $address='')
    {
        $this->point = $point;
        $this->city = $city;
        $this->country = $country;
        $this->address = $address;
    }

    public function graph()
    {
        return Entity::graph(
            ['Location']
        )
        ->properties(
            [
                'point'     => Type::Object(Point::create()),
                'city'      => Type::String(),
                'country'   => Type::String(),
                'address'   => Type::String()
            ]
        );
    }
}