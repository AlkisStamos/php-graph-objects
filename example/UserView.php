<?php

namespace Nuad\Graph\Example;

class UserView
{
    /**
     * @var User[]
     */
    public $users;

    public function showUsersPage(Array $users)
    {
        $this->users = $users;
        include 'user.tmpl.php';
        exit();
    }
}