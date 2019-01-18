<?php
    include("singin_sc.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type= "text/css" href="style.css">
        <title>ログイン</title>
    </head>
    <body>
        <header class="header">
            <div class="header_wrap">
                <div class="login">
                    <a href="" class ='Home'>Home</a> 
                    <a href="" class ='Singin'>Sing in</a>
                    <a href="singup.php" class ='Singup'>Sing up</a>
                </div>
            </div>
        </header>
        <section id = "main">
            <article class="form-wrap">
                <form action="" method="post" class = "singup-form">
                    <h2>ログイン</h2>
                    <div class="input_area">
                        <label>E-Mail<span class = "required">*</span></label>
                        <input type="text" name ="email" class="email" placeholder="E-Mail">
                    </div>
                    <div class="input_area">
                        <label>Password<span class = "required">*</span></label>
                        <input type="password" name="password" class="password" placeholder="Password">
                    </div>
                    <label>
                        <input type="checkbox" name="singin_save" class = "article__checkbox singin_save">ログイン状態を保持する
                    </label>
                    <div class="input_area">
                        <input type="submit" class="btn" value="ログイン">
                        <a href="" class="article__link">パスワードを忘れた場合</a>
                    </div>
                </form>
            </article>
        </section>
    </body>
</html>