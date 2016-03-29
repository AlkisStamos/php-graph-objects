<?php
/**
 * Developer: alkis_stamos
 * Date: 3/29/16
 * Time: 9:42 PM
 */
return array(

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
    'str_val'  => 'string-expected-third',
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
);