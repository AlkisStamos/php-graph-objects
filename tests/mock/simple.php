<?php
/**
 * Developer: alkis_stamos
 * Date: 3/30/16
 * Time: 12:15 AM
 */
return array(
    'simple_integer' => 5,
    'simple-str' => 'a sample string',
    'simpleMixed' => '123',
    'simple-mixed' => \Nuad\Graph\Test\GraphSimple::map([
        'simple_integer' => 10,
        'simple-str' => 'another sample string',
        'simpleMixed' => [1,2,3]
    ])
);