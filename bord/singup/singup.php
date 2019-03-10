<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type= "text/css" href="../style.css">
        <link rel="stylesheet" type= "text/css" href="../header_style.css">
        <title>ユーザー登録</title>
    </head>
    <body>
        <header class="header">
            <?php include('../parts/headerUnauth.php') ?>
        </header>
        <section id = "main">
            <article class="form-wrap">
                <form action="" method="post" class = "singup_form">
                    <h2>ユーザー登録</h2>
                    <!--
                    <div class="input_area">
                        <label>User Name<span class = "required">*</span></label>
                        <input type="text" name="username" class="username" placeholder="User Name" value=
                            <?php
                                if(!empty($_POST['username'])) echo $_POST['username'];
                            ?>
                        >
                        <p class ="description">この名前が投稿者名になります。</p>
                        <?php if(!empty($err_msg['username'])) echo $err_msg['username']; ?>
                    </div>
                    -->
                    <div class="input_area">
                        <label>E-Mail<span class = "required">*</span><label class ="description">パスワード再発行などに使用されます。</label></label>
                        <input type="text" name="email" class="email" id="email_input" placeholder="E-Mail" value=
                            <?php
                                if(!empty($_POST['email'])) echo $_POST['email'];
                            ?>>
                        <div id="email_mess_area">
                            <p class = "description" id = "email-js" ></p>
                        </div>
                    </div>
                    <div class="input_area">
                        <label>Password<span class = "required">*</span></label>
                        <input type="password" name="password" class="password" placeholder="Password" value=
                            <?php
                                if(!empty($_POST['password'])) echo $_POST['password'];
                            ?>>
                        <p class ="description">8文字以上で半角英数文字を使用してください。</p>
                        <?php if(!empty($err_msg['password'])) echo $err_msg['password']; ?>
                    </div>
                    <div class="input_area">
                        <input type="submit" class="btn no-singup" value="登録">
                    </div>
                    <?php if(!empty($err_msg['common'])) echo $err_msg['common'];?>
                </form>
            </article>
        </section>
    </body>
    <script src="singup.js"></script>
</html>