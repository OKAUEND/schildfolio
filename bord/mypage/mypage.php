<?php
    //ログイン認証をし、不正アクセスを防ぐ
    require('auth.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type= "text/css" href="style.css">
        <title>マイページ</title>
    </head>
    <body>
        <header class="header">
            <div class="header_wrap">
                <div class="login">
                    <a href="" class ='Home'>家計簿をつける</a> 
                    <a href="logout.php" class =''>ログアウト</a>
                    <a href="#" class =''>マイページ</a>
                </div>
            </div>
        </header>
        <section id = "main_content">
            <article class="article-sidebar">
                <div class="article-sidebar__list">
                    <div class="article-sidebar__item">
                        <img src="img/users_img/temple.png" alt="テスト" class="article-sidebar__img">
                    </div>
                    <div class="article-sidebar__item">
                        <p class = "article-sidebar__txt">ホゲタホゲ子</p>
                    </div>
                    <div class="article-sidebar__item">
                        <p class = "article-sidebar__txt">プロフィールプロフィールプロフィールプロフィールプロフィールプロフィールプロフィール</p>
                    </div>
                </div>
                <div class="article-sidebar__list">
                    <div class="article-sidebar__item">
                        <h3>今月の出費</h3>
                        <span class="article-sidebar__txt">3,000円</span>
                    </div>
                </div>
            </article>
            <article class="article-main">
                <div class="article-main__list show-warning">
                    <h3 class="artcle-main__txt">消費期限が切れた食材達</h3>
                    <div class="article-main__container">
                        <div class="article-main__item icon_img">
                            <img src="img/food_icon/chicken.png" alt="">
                        </div>
                        <div class="article-main__item name_txt">
                            <p>鶏肉</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>400g</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>580円</p> 
                        </div>
                        <div class="article-main__item limit_txt">
                            <p>2019年1月20日</p>
                        </div>
                    </div>
                    <div class="article-main__container">
                        <div class="article-main__item icon_img">
                            <img src="img/food_icon/none.png" alt="食材">
                        </div>
                        <div class="article-main__item name_txt">
                            <p>サバ</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>1尾</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>450円</p> 
                        </div>
                        <div class="article-main__item limit_txt">
                            <p>2019年1月18日</p>
                        </div>
                    </div>
                </div>
                <div class="article-main__list show-Notice">
                    <h3 class="artcle-main__txt">そろそろ危ない食材達</h3>
                    <div class="article-main__container">
                        <div class="article-main__item icon_img">
                            <img src="img/food_icon/none.png" alt="">
                        </div>
                        <div class="article-main__item name_txt">
                            <p>牛肉</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>200g</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>20080円</p> 
                        </div>
                        <div class="article-main__item limit_txt">
                            <p>2019年1月23日</p>
                        </div>
                    </div>
                    <div class="article-main__container">
                        <div class="article-main__item icon_img">
                            <img src="img/food_icon/none.png" alt="食材">
                        </div>
                        <div class="article-main__item name_txt">
                            <p>たら</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>300g</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>450円</p> 
                        </div>
                        <div class="article-main__item limit_txt">
                            <p>2019年1月23日</p>
                        </div>
                    </div>
                </div>
                <div class="article-main__list show-todaybuy">
                    <h3 class="artcle-main__txt">今日のお買い物</h3>
                <div class="article-main__container">
                        <div class="article-main__item icon_img">
                            <img src="img/food_icon/none.png" alt="">
                        </div>
                        <div class="article-main__item name_txt">
                            <p>豚肉</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>500g</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>20080円</p> 
                        </div>
                        <div class="article-main__item limit_txt">
                            <p>2019年1月25日</p>
                        </div>
                    </div>
                    <div class="article-main__container">
                        <div class="article-main__item icon_img">
                            <img src="img/food_icon/none.png" alt="食材">
                        </div>
                        <div class="article-main__item name_txt">
                            <p>ふぐ</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>500g</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>1950円</p> 
                        </div>
                        <div class="article-main__item limit_txt">
                            <p>2019年1月24日</p>
                        </div>
                    </div>
                    <div class="article-main__container">
                        <div class="article-main__item icon_img">
                            <img src="img/food_icon/none.png" alt="食材">
                        </div>
                        <div class="article-main__item name_txt">
                            <p>リミテッドガチャ</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>300連</p>
                        </div>
                        <div class="article-main__item value_txt">
                            <p>90000円</p> 
                        </div>
                        <div class="article-main__item limit_txt">
                            <p>--</p>
                        </div>
                    </div>
                </div>
            </article>
        </section>
    </body>
</html>