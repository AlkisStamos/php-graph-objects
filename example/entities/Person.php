<?php

namespace Nuad\Graph\Example;

use Nuad\Graph\Core\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Core\Type;

class Person implements Graphable
{
    use GraphAdapter;

    public $id;
    public $name;
    public $gender;

    /**
     * Person constructor.
     * @param $id
     * @param $name
     * @param $gender
     */
    public function __construct($id=0, $name='', $gender='')
    {
        $this->id = $id;
        $this->name = $name;
        $this->gender = $gender;
    }

    public static function create()
    {
        return new self(0,'','');
    }

    /**
     * @return Entity
     */
    public function graph()
    {
        return Entity::graph(
            ['Person']
        )
        ->properties(
            [
                'id'        => Type::Integer(),
                'name'      => Type::String(),
                'gender'    => Type::String()
            ]
        );
    }
}