window.addEventListener('load',function(){

    const thread_data = new thread;
    let botton = document.querySelector("#btnsubmit");

    fetchCommentdata(thread_data).then(function (data)
    {
        console.log('ajax処理がおわったよ');
        showComment(data);
    },);

    console.log('先にこっち');

    //データベースへ登録する 書き込みをする
    botton.addEventListener('click',function(){
        console.log('クリック');
        let comment_txt = document.querySelector(".comment").value;

        var wait = false;
        if(comment_txt.length > 0 && !wait)
        {
            wait = true;
            let input_list = [];
            input_list['username'] = document.querySelector(".username").value;
            input_list['email'] = document.querySelector(".email").value;
            input_list['deletepass'] = document.querySelector(".deletepass").value;
            input_list.push(thread_data.getThreadinfo());

            insertInputData(input_list).then((result) =>
            {
                return fetchCommentdata(thread_data.getThreadinfo());
            })
            .then((result) => 
            {
                showComment(result);
                wait = false;
            })
            .catch((err) =>
            {
                wait = false;
            });
        }
        else
        {
            console.log('処理してないよ。こっちきたよ')
        }
    },false);



},false);

function fetchCommentdata(thread_data)
{
    return new Promise(function(resolve,reject)
    {
        let xhr = new XMLHttpRequest();
        xhr.open('POST','fetchAjax.php',true);
        xhr.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
        //現在のスレッド情報を取得する
        let Threadinfo = thread_data.getThreadinfo();
    
        xhr.send(
            'thread_id='         + encodeURIComponent(Threadinfo['thread_id'])   + '&' +
            'last_res_no='       + encodeURIComponent(Threadinfo['last_res_no']) + '&' +  
            'last_res_time='     + encodeURIComponent(Threadinfo['last_res_time']) 
        );
    
        xhr.onreadystatechange = function()
        {
            switch(xhr.readyState)
            {
                case 1:
                    break;
                
                case 2:
                    break;
    
                case 3:
                    break;
                
                case 4:
                    if(xhr.status == 200)
                    {
                        let data = JSON.parse(xhr.responseText);
                        resolve(data);
                    }
                    break;
            }
        }
    })
}

function insertInputData($array)
{
    return new Promise(function(resolve,reject)
    {
        let req = new XMLHttpRequest();
        req.open('POST','writingAjax.php',true);
        req.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
        req.send(
            'name='         + encodeURIComponent(username)      + '&' +
            'email='        + encodeURIComponent(email)         + '&' +
            'delete_pass='  + encodeURIComponent(deletepass)    + '&' +
            'comment='      + encodeURIComponent(comment_txt)   + '&' +
            'thread_id='    + encodeURIComponent(Threadinfo['thread_id'])      + '&' +
            'res_no='       + encodeURIComponent(Threadinfo['last_res_no']),
            );
        req.onreadystatechange = function()
        {
            switch(xhr.readyState)
            {
                case 1:
                    break;
                
                case 2:
                    break;
    
                case 3:
                    break;
                
                case 4:
                    if(xhr.status == 200)
                    {
                        let result = JSON.parse(xhr.responseText);
                        resolve(result);
                    }
                    break;
            }
        }
    })
}


function showComment(array)
{
   let comment_area = document.querySelector('#main-view');
   let fragment = document.createDocumentFragment();

   array.forEach(element => {
       let $div = document.createElement('div');
       let $span_username   = document.createElement('span');
       $span_username.appendChild(document.createTextNode(element['username']));
       let $span_writingtime = document.createElement('span');
       $span_writingtime.appendChild(document.createTextNode(element['create_data']));

       let $p_comment = document.createElement('p');
       $p_comment.appendChild(document.createTextNode(element['comment']));

       $div.appendChild($span_username);
       $div.appendChild($span_writingtime);
       $div.appendChild($p_comment);

       fragment.appendChild($div);
   });

   comment_area.appendChild(fragment);
}

//スレッドデータ管理クラス
class thread
{
    _thread_id;
    _response_list;
    _last_res_no;
    _last_res_time;

    constructor()
    {
        this._thread_id = 0;
        this._response_list = {};
        this._last_res_no = 0;
        this._last_res_time = null;
    }

    set threadinfo(array)
    {
        console.log(array);
        //console.log(last_data['create_data']);
        this._last_res_no = Number(array['ID']);
        this._last_res_time = array['create_data'];
        console.log(this._last_res_no);
    }

    getThreadinfo()
    {
        let result = [];
        result['thread_id']     = this.thread_id;
        result['last_res_no']   = this.last_res_no;
        result['last_res_time'] = this.last_res_time;
        return result;
    }
}

