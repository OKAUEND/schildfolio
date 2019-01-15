<?php

    require('function.php');

    if(!empty($_POST))
    {

        //IsVaildSymbol($_POST['username'],"");

        IsVaildHalfString($_POST['password'],'password');

        //文字入力チェック(全チェック)
        foreach($_POST as $key => $value)
        {
            IsNullRequired($value,$key);
        }

        if(!empty($err_msg))
        {
            return;
        }

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];



    }

        if(!empty($err_msg))
        {
            return;
        }

        //IsVaildpassword($_POST['password'],'password');


        IsEmailDup("","");
        var_dump($err_msg);
        global $err_msg;
        $err_msg['common'] = "文字を入力して下さい。";