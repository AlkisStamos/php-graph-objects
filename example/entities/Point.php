<?php

namespace Nuad\Graph\Example;

use Nuad\Graph\Core\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Core\Type;

class Point implements Graphable
{
    use GraphAdapter;
    /**
     * @var float
     */
    public $lat;
    /**
     * @var float
     */
    public $lng;

    public function __construct($lat=0.0, $lng=0.0)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function graph()
    {
        return Entity::graph(
            ['Point']
        )
        ->properties(
            [
                'lat'   => Type::Double()
                ->expected(array('latitude')),
                'lng'   => Type::Double()
                ->expected(array('longitude'))
            ]
        );
    }
}