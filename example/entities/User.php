<?php

namespace Nuad\Graph\Example;

use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Core\Type;

class User extends Person
{
    use GraphAdapter;

    /**
     * @var int
     */
    public $age;
    /**
     * @var string
     */
    public $email;
    /**
     * @var boolean
     */
    public $loggedIn;
    /**
     * @var Location
     */
    public $location;
    /**
     * @var Person[]
     */
    public $friends;

    public function __construct($id,$name,$gender,$age, $email, $loggedIn, $location, $friends)
    {
        parent::__construct($id,$name,$gender);
        $this->age = $age;
        $this->email = $email;
        $this->loggedIn = $loggedIn;
        $this->location = $location;
        $this->friends = $friends;
    }

    public function graph()
    {
        return parent::graph()->extend(
            ['User']
        )
        ->properties(
            [
                'age'       => Type::Integer(),
                'email'     => Type::String(),
                'loggedIn'  => Type::Boolean(),
                'location'  => Type::Object(Location::create()),
                'friends'   => Type::Collection(Person::create())
            ]
        )
        ->finalize(function(User $instance)
        {
            $instance->email .= '__appended_finalized_value';
        });
    }
}