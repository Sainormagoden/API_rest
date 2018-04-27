<?php

require_once "Autoloader.php";

if (isset($_GET['id'])){
    $id = $_GET['id'];

}

foreach (SPDO::getInstance()->query('SELECT id, lastname, firstname, email, role FROM user WHERE id='.$id) as $user)
{
    echo '<pre>', print_r($user) ,'</pre>';
}