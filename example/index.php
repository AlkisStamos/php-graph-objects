<?php
/**
 * Created by IntelliJ IDEA.
 * User: smiley
 * Date: 1/5/16
 * Time: 5:59 PM
 */

require '../vendor/autoload.php';

$userData = json_decode(file_get_contents('data/users.json'),true);
/**
 * @var \Nuad\Graph\Example\User[] $users
 */
$users = array();

foreach($userData as $data)
{
    $users[] = \Nuad\Graph\Example\User::map($data);
}

$view = new \Nuad\Graph\Example\UserView();
$view->showUsersPage($users);