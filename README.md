PHP assoc array to class properties
===================


Graph objects is a php5 hydrator which maps associative arrays to class instances using metadata defined in their classes, useful when working with database result sets or formats that can be easily formatted to assoc arrays (such as json).

The library has no extra requirements (except phpunit for testing).  It does not require custom annotation syntax or makes use of doc comments in order to limit reflection usage and to keep things as simple and light as possible.

----------

Installation
-------------
Installing ```nuad/graph-objects``` with composer:
```
$ composer require nuad/graph-objects
```

Usage
-------------

All the project files are under the Nuad/Graph namespace. The main interface that all graph objects must implement is the Graphable interface and all the functionality is in the GraphAdapter trait.

The two main methods that the library uses are the create() and graph() methods. The first one will just output a clean instance of an object and the second one will provide the metadata to map the assoc array to the object. Though the GraphAdapter provides a version of the create() method (that uses reflection to create the instance) the method may be to have an object created with whatever default values.

So assuming there is a dto,entity etc class called Person which may work as a base class for a User object. A simple definition of the Person class would be:
```
class Person
{
    public $id;
    public $name;
    public $gender;

    public function __construct($id, $name, $gender)
    {
        $this->id = $id;
        $this->name = $name;
        $this->gender = $gender;
    }
}
```
Now to put the library in use the above class becomes:
```
use Nuad\Graph\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Type;

class Person implements Graphable
{
    use GraphAdapter;

    public $id;
    public $name;
    public $gender;

    public function __construct($id, $name, $gender)
    {
        $this->id = $id;
        $this->name = $name;
        $this->gender = $gender;
    }

	public static function create()
    {
        return new self(0,'','');
    }

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
```
> **Note:** The create method can be ignored as we can use the traits create() method but this way we can create an instance without the use of Reflection.

Now to use the class to map a $data assoc array lets say from a JSON format:
```
//person.json
{
     "id": 1,
     "name": "Jewell Lester",
     "gender": "female"
}
```
```
$data = json_decode(file_get_contents('person.json'),true);
$person = Person::map($data);
```
Now the $person var should be a new Person instance with the data from the json file.

#### Syntax

The graph method must return an Entity object. The Entity's constructor requires an array of names which will identify the class.
The Entity contains a list of properties (defined with the properties() method) which is an assoc array with keys the names of the properties of the main class and values the type of each property.

#### Types
The types of the properties are divided in three main categories
> - **flat types** (Integer,Double,Boolean,FlatArray)
> - **objects** (refers to another graph object. The constructor requires a clean instance of that object)
> - **collection** (refers to an array of graph objects. The constructor also requires a clean instance of that object)

#### Inheritance and more complex types

Using the example above we will define a User class which will extend the Person and contain a Location object which will contain a Point object.

The extra Location and Point classes:
```
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
```
>**Note:** The Location contains an object named point which is of type Point and is defined as such in the graph() method. The Point graph defines expected arrays to both of its properties. In the expected attribute you may put variations of the property name which may be encountered in the data.

And now to define the User child class:

```
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
        );
    }
}
```
>**Note:** The GraphAdapter trait **must** be defined again and in the graph() method we extend the graph() method of the parent class as seen above.


Features
----------
* **Inject**:

   Using the inject method instead of the map method will force the GraphAdapter trait to use the constructor of the object instead. Also the **injectWithInstance** Method accepts a graph object instance as parameter which will use to map the data.
* **Map empty**:

   The mapEmpty method of the trait will map only values of the object which are null. Useful when creating object properties in separate steps.
* **Expected & bind**:

   The Type's expected() method accepts an array of indexes on where the values of the property may be found in the incoming data. The property names will be preferred over the expected values. To override this behaviour use the bind method (also accepts an array of indexes which will be preferred over expected values and property names).
   Syntax:
   ```
   'id'    => Type::String()
    ->bindTo(['_id','ID'])
    ->expected(['identity','identifier','identification'])
   ```
* **Callbacks**:

   The Entity takes a finalize callback (through the finalize() method) which gives access to the mapped object and the raw data as soon as the mapping is complete, can be used to validate object properties before continuing.

   The Type takes a handler callback (through the handler() method) which will provide access to the data found in the payload for that property and the index where the data were found. If defined the returned value of the handler will be used instead, if the handler callback returns null the adapter will continue to map the property normally.
    ```
   return Entity::graph(
            ['Person']
        )
        ->properties(
        [
            'id'        => Type::Integer(),
            'name'      => Type::String(),
            'gender'    => Type::String()
            ->handler(function($data,$name,$scenario)
            {
                return $data === 'fem' ? 'female' : 'male'
            })
        ]
        )->finalize(function(Person $instance, $scenario, $data)
        {
            if($instance->id === null)
            {
                throw new Exception('invalid person data');
            }
        });
   ```
   >**Note:** Both callbacks give access to a variable named 'scenario'. This variable can be passed through the inject/map methods and can be useful when a property is used different scenarios, for example different locale data.