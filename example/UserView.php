<?php
/**
 * Created by IntelliJ IDEA.
 * User: smiley
 * Date: 1/5/16
 * Time: 6:07 PM
 */

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