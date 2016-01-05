<?php
/**
 * Created by IntelliJ IDEA.
 * User: smiley
 * Date: 1/5/16
 * Time: 6:07 PM
 */
/**
 * @var \Nuad\Graph\Example\UserView $this
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php foreach($this->users as $user): ?>
    <h1><?=$user->name?></h1>
    <hr/>
    <ul>
        <li>Gender: <?=$user->gender?></li>
        <li>Age: <?=$user->age?> years old</li>
        <li>City: <?=$user->location->city?></li>
        <li>Country: <?=$user->location->country?></li>
    </ul>
    <h2>Friends</h2>
    <ul>
        <?php foreach($user->friends as $friend): ?>
            <li><?=$friend->name?></li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>
</body>
</html>
