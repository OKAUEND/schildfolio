window.addEventListener('load',function(){

    let thread_id = 0;
    let res_no = 0;
    let botton = document.querySelector("#btnsubmit");
    //データベースへ登録する 書き込みをする
    botton.addEventListener('click',function(){
        console.log('クリック');
        let comment_txt = document.querySelector(".comment").value;
        
        let wait = false;
        if(comment_txt.length > 0 && !wait)
        {
            let username = document.querySelector(".username").value;
            let email = document.querySelector(".email").value;
            let deletepass = document.querySelector(".deletepass").value;
            let req = new XMLHttpRequest();
            req.onreadystatechange = function()
            {
                if(req.readyState == 4 && req.status == 200)
                {
                    wait = false
                    let data = req.responseText;
                    let view_item = JSON.parse(data);
                    console.log(view_item); 
                }
                else
                {
                    wait = true;
                    console.log('通信待機中');
                }
            }
            req.open('POST','writingAjax.php',true);
            req.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
            req.send(
                'name='         + encodeURIComponent(username)      + '&' +
                'email='        + encodeURIComponent(email)         + '&' +
                'delete_pass='  + encodeURIComponent(deletepass)    + '&' +
                'comment='      + encodeURIComponent(comment_txt)   + '&' +
                'thread_id='    + encodeURIComponent(thread_id)      + '&' +
                'res_no='       + encodeURIComponent(res_no),
                );
        }
        else
        {
            console.log('処理してないよ。こっちきたよ')
        }
    },false);
},false);