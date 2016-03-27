<?php
/**
 * Developer: alkis_stamos
 * Date: 3/28/16
 * Time: 12:23 AM
 */
return array(
    'id' => 65987,
    'flatNest' => array(
        'integer' => '17',
        'array' => array(
            '12','13','14'
        ),
        'nest' => array(
            'integer' => 356
        )
    ),
    'objectNest' => array(
        'base' => array(
            'aString' => 'astringvalue',
            'anInteger' => 5,
            'aBoolean'  => false,
            'flatArray' => array(
                'a','b','c','d'
            ),
            'aDouble'   => 5.5
        ),
        'nest' => array(
            'child' => array(
                'aString' => 'astringvalue',
                'anInteger' => 5,
                'aBoolean'  => false,
                'flatArray' => array(
                    'a','b','c','d'
                ),
                'aDouble'   => 5.5,
                'childValueStr' => 'anotherstringvalue',
                'childValueBool' => true
            )
        )
    ),
    'aproperty' => 'theproperty',
    'preferedproperty' => 'preferedproperty'
);