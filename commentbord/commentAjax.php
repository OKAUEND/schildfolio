<?php

header('Content-Type: application/json; charset=UTF-8');

if(!empty($_POST))
{
    $username = $_POST['name'];
    $email = $_POST['email'];
    $deletepass = $_POST['deletepass'];
    $comment = $_POST['comment'];

    try
    {

    }
    catch(Exception $ex)
    {
        
    }
}