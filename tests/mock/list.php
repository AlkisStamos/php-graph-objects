<?php
return array(
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
            'aBoolean'  => true,
            'flatArray' => array(
                'a', 'b', 'c', 'd'
            ),
            'aDouble'   => 10.5,
            'childValueStr' => 'anotherstringvaluewithdiff',
            'childValueBool' => false
        )
    ),
    'baseList' => array(
        array(
            'aString' => 'astringvalue0',
            'anInteger' => 0,
            'aBoolean'  => false,
            'flatArray' => array(
                'a','b','c','d'
            ),
            'aDouble'   => 0.5
        ),
        array(
            'aString' => 'astringvalue1',
            'anInteger' => 1,
            'aBoolean'  => false,
            'flatArray' => array(
                'a','b','c','d'
            ),
            'aDouble'   => 1.5
        ),
        array(
            'aString' => 'astringvalue2',
            'anInteger' => 2,
            'aBoolean'  => false,
            'flatArray' => array(
                'a','b','c','d'
            ),
            'aDouble'   => 2.5
        )
    )
);