window.addEventListener('load',function(){

    let botton = document.querySelector("#btnsubmit");
    //データベースへ登録する
    botton.addEventListener('click',function(){
        let comment_txt = document.querySelector(".comment").textContent;
        let wait = false;
        if(comment_txt.length > 0 && !wait)
        {
            let username = document.querySelector('.username');
            let email = document.querySelector('.email');
            let deletepass = document.querySelector('.deletepass');

            let req = new XMLHttpRequest();
            req.onreadystatechange = function()
            {
                if(req.readyState == 4 && req.status == 200)
                {
                    wait = false
                }
                else
                {
                    wait = true;
                    console.log('通信待機中');
                }
            }
            req.open('POST','commentAjax.php',true);
            req.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
            req.send(
                'name='         + encodeURIComponent(username)      + '&' +
                'email='        + encodeURIComponent(email)         + '&' +
                'deletepass'    + encodeURIComponent(deletepass)    + '&' +
                'comment_txt'   + encodeURIComponent(comment_txt)
                );
        }
        else
        {
            console.log('通信中です')
        }
    },false);
},false);