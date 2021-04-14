<?php
/**
 * Developer: alkis_stamos
 * Date: 4/1/16
 * Time: 10:41 PM
 */

$anObj = new stdClass();
$anObj->property = 1;
$anObj->otherProperty = 2;

return array(
    'base' => array(
        'aString' => 'astringvalue',
        'anInteger' => 5,
        'aBoolean' => false,
        'flatArray' => array(
            'a', 'b', 'c', 'd'
        ),
        'aDouble' => 5.5
    ),
    'base_weak_types' => array(
        'aString' => 'astringvalue',
        'anInteger' => '5',
        'aBoolean' => 'false',
        'flatArray' => array(
            'a', 'b', 'c', 'd'
        ),
        'aDouble' => '5.5'
    ),
    'child_parent_diff' => array(
        'aString' => 'adiffvalue',
        'anInteger' => 12,
        'aBoolean' => true,
        'flatArray' => array(
            'e', 'f', 'g', 'h'
        ),
        'aDouble' => 10.5,
        'childValueStr' => 'anotherstringvaluewithdiff',
        'childValueBool' => false
    ),
    'child' => array(
        'aString' => 'astringvalue',
        'anInteger' => 5,
        'aBoolean' => false,
        'flatArray' => array(
            'a', 'b', 'c', 'd'
        ),
        'aDouble' => 5.5,
        'childValueStr' => 'anotherstringvalue',
        'childValueBool' => true
    ),
    'child_expected' => array(
        'aString' => 'astringvalue',
        'integer_val' => 5,
        'aBoolean' => false,
        'flatArray' => array(
            'a', 'b', 'c', 'd'
        ),
        'aDouble' => 5.5,
        'child_val_str' => 'anotherstringvalue',
        'child_val_bool' => true
    ),
    'expected' => array(
        'simpleInteger' => '00000',
        'simple-integer' => 11,
        'simple_integer' => 12,
        'simpleInt' => 21,
        'simple-int' => 22,
        'simpleString' => 'simple-string-default',
        'simple_string' => 'simple-string-bind-second',
        'simple-str' => 'simple-string-expected-second',

        'alphanumeric' => 'string-bind-second',
        'str' => 'string-bind-first',
        '__string' => 'string-expected-first',
        'string__' => 'string-expected-second',
        'str_val' => 'string-expected-third',
        'string' => 'string-default',

        'integer' => '0',
        'int' => 11,
        '__integer' => 21,
        '__int' => 22,
        'int_val' => 23,

        'simpleCollection' => array(
            0 => [
                'simpleInteger' => '00000',
                'simpleString' => 'simple-string-default',
            ],
            1 => [
                'simpleInteger' => '00000',
                'simple_integer' => 12,
                'simpleString' => 'simple-string-default',
                'simple_string' => 'simple-string-bind-second',
            ]
        ),

        'simples' => array(
            [
                'simple-int' => 22,
                'simple-str' => 'simple-string-expected-second',
            ]
        ),

        'simple-data' => array(
            [
                'simple-integer' => 11,
                'simple-str' => 'simple-string-expected-second2',
            ]
        ),

        'nested' => array(
            'simple' => [
                'simpleInteger' => '1',
                'simpleString' => 'simple-string-default',
            ]
        ),

        'simple' => array(
            'nested' => [
                'simple-int' => '2',
                'simple-string' => 'simple-string-expected',
            ]
        )
    ),
    'list' => array(
        'assoc' => array(
            'one' => 1,
            'two' => 'second',
            'three' => 3
        ),
        'nest' => array(
            'ownProperty' => 'thisisastringnested',
            'child' => array(
                'aString' => 'astringvalue',
                'anInteger' => 12,
                'aBoolean' => true,
                'flatArray' => array(
                    'a', 'b', 'c', 'd'
                ),
                'aDouble' => 10.5,
                'childValueStr' => 'anotherstringvaluewithdiff',
                'childValueBool' => false
            )
        ),
        'baseList' => array(
            array(
                'aString' => 'astringvalue0',
                'anInteger' => 0,
                'aBoolean' => false,
                'flatArray' => array(
                    'a', 'b', 'c', 'd'
                ),
                'aDouble' => 0.5
            ),
            array(
                'aString' => 'astringvalue1',
                'anInteger' => 1,
                'aBoolean' => false,
                'flatArray' => array(
                    'a', 'b', 'c', 'd'
                ),
                'aDouble' => 1.5
            ),
            array(
                'aString' => 'astringvalue2',
                'anInteger' => 2,
                'aBoolean' => false,
                'flatArray' => array(
                    'a', 'b', 'c', 'd'
                ),
                'aDouble' => 2.5
            )
        )
    ),
    'nested' => array(
        'ownProperty' => 'thisisastringnested',
        'child' => array(
            'aString' => 'astringvalue',
            'anInteger' => 12,
            'aBoolean' => true,
            'flatArray' => array(
                'a', 'b', 'c', 'd'
            ),
            'aDouble' => 10.5,
            'childValueStr' => 'anotherstringvaluewithdiff',
            'childValueBool' => false
        )
    ),
    'nested_data' => array(
        'id' => 65987,
        'flatNest' => array(
            'integer' => '17',
            'array' => array(
                '12', '13', '14'
            ),
            'nest' => array(
                'integer' => 356
            )
        ),
        'objectNest' => array(
            'base' => array(
                'aString' => 'astringvalue',
                'anInteger' => 5,
                'aBoolean' => false,
                'flatArray' => array(
                    'a', 'b', 'c', 'd'
                ),
                'aDouble' => 5.5
            ),
            'nest' => array(
                'child' => array(
                    'aString' => 'astringvalue',
                    'anInteger' => 5,
                    'aBoolean' => false,
                    'flatArray' => array(
                        'a', 'b', 'c', 'd'
                    ),
                    'aDouble' => 5.5,
                    'childValueStr' => 'anotherstringvalue',
                    'childValueBool' => true
                )
            )
        ),
        'aproperty' => 'theproperty',
        'preferedproperty' => 'preferedproperty'
    ),
    'simple' => array(
        'simple_integer' => 5,
        'simple-str' => 'a sample string',
        'simpleMixed' => '123',
        'simple-mixed' => \Nuad\Graph\Test\Tests\GraphSimple::map([
            'simple_integer' => 10,
            'simple-str' => 'another sample string',
            'simpleMixed' => [1, 2, 3]
        ])
    ),
    'step_properties' => array(
        'someProperty' => 'aproperty',
        'someOtherProperty' => 1
    ),
    'flat' => array(
        'typecast_normal' => array(
            'aString' => 14,
            'anInteger' => '5',
            'aBoolean' => '1',
            'flatArray' => $anObj,
            'aDouble' => 2
        ),
        'typecast_diff' => array(
            'aString' => true,
            'anInteger' => '1.1',
            'aBoolean' => 'true',
            'flatArray' => new stdClass(),
            'aDouble' => '-.6'
        ),
        'typecast_fail' => array(
            'aString' => [],
            'anInteger' => 'test',
            'aBoolean' => '75',
            'flatArray' => 2,
            'aDouble' => 'test'
        )
    ),
    'mixed' => array(
        'mixedStandard' => $anObj,
        'objectNest' => array(
            'base' => array(
                'aString' => 'astringvalue',
                'anInteger' => 5,
                'aBoolean' => false,
                'flatArray' => array(
                    'a', 'b', 'c', 'd'
                ),
                'aDouble' => 5.5
            )
        ),
        'simple' => array(
            'simple_integer' => 5,
            'simple-str' => 'a sample string',
            'simpleMixed' => '123',
        ),
        'mixedCustom' => 'avalue',
        'nest' => array(
            'mixedCustom2' => 'anotherValue'
        )
    )
);
