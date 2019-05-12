window.addEventListener('load',function(){

    const thread_data = new thread;
    let submit = document.querySelector("#btnsubmit");
    let reload = document.querySelector('#btnreload');
    let delbtn = document.querySelector('#btndelete');

    //初回読み込み
    fetchCommentdata(thread_data).then((data) =>
    {
        createCommentDOM(data,thread_data);
        thread_data.threadinfo = data;
    });

    //データベースへ登録する 書き込みをする
    submit.addEventListener('click',function(){
        console.log('クリック');
        let comment = document.querySelector(".main-form_textarea").value;

        var wait = false;
        if(comment.length == 0 && wait)
        {
            return false;
        }

        wait = true;
        let input_list = [];
        input_list['username'] = document.querySelector(".username").value;
        input_list['email'] = document.querySelector(".email").value;
        input_list['deletepass'] = document.querySelector(".deletepass").value;
        input_list['comment'] = comment;
        input_list.push(thread_data.threadinfo);

        insertInputData(input_list).then((result) =>
        {
            return fetchCommentdata(result,thread_data);
        })
        .then((result) => 
        {
            if(result.length > 0)
            {
                createCommentDOM(result,thread_data);
            }
            wait = false;
        })
        .catch((err) =>
        {
            //エラー表示をモーダル画面で表示する(予定)
            wait = false;
        });
    },false);

    //更新ボタン押下時のスレッド内容読み取り
    reload.addEventListener('click' ,() =>
    {
        let wait = false;

        if(wait)
        {
            return false;
        }

        wait = true;
        fetchCommentdata(thread_data).then((result) =>
        {
            createCommentDOM(result,thread_data);
            thread_data.threadinfo = data;
            wait = false;
        })
        .catch((err) =>
        {
            //エラー表示をモーダル画面で表示する(予定)
            wait = false;
        })
    },false);

    //削除ボタン
    delbtn.addEventListener('click',() =>
    {
        let delete_text = document.querySelector('.delete_pas').value;

        //削除パスワードを入力されていないときは処理を終了する
        //製作中はコメント化をして判定を省く
        // if(delete_text.length == 0)
        // {
        //     return;
        // }

        let response_id_list = []; 

        //チェックした返信レスのIDをピックアップする
        for(let count = 0; count < document.comment_area.delete_check.length ; count++)
        {
            if(document.comment_area.delete_check[count].checked)
            {
                response_id_list.push(document.comment_area.delete_check[count].value);
            }
        }

        //該当レスIDがデータベースに存在するかを検索する
        searchRecode(thread_data,response_id_list).then((result) =>
        {

            //サーバーから取得したIDが、ピックアップしたレスのIDと合致しているか
            let isIncludes  = result.every((value) =>
            {
                return (response_id_list.includes(value['ID']))
            })

            //選んでいたレスがすべてサーバーに存在する場合、削除処理を実施
            if(isIncludes)
            {
                //削除処理を行う
                deleteRecode(thread_data.threadinfo,response_id_list);
            }
        })
        .then((result) =>
        {
            let isIncludes;
        })
        .catch((err) =>
        {
            console.log('サバエラー');
        })

    },false);

},false);

//非同期スレッド内容取得処理
function fetchCommentdata(thread_data)
{
    return new Promise(function(resolve,reject)
    {
        let xhr = new XMLHttpRequest();
        xhr.open('POST','fetchAjax.php',true);
        xhr.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
        //現在のスレッド情報を取得する
        let Threadinfo = thread_data.threadinfo;

        xhr.send(
            'page_type='         + encodeURIComponent(Threadinfo['page_type'])   + '&' +
            'thread_id='         + encodeURIComponent(Threadinfo['thread_id'])   + '&' +
            'last_res_no='       + encodeURIComponent(Threadinfo['last_database_id']) + '&' +  
            'last_res_time='     + encodeURIComponent(Threadinfo['last_update_time']) 
        );

        xhr.onreadystatechange = function()
        {
            switch(xhr.readyState)
            {
                case 4:
                    if(xhr.status == 200)
                    {
                        let data = JSON.parse(xhr.responseText);
                        resolve(data);
                    }
                    else if(xhr.status == 500)
                    {
                        reject('500')
                    }
                    break;
            }
        }
    })
}

//非同期スレッド内容書き込み処理
function insertInputData($array)
{
    return new Promise(function(resolve,reject)
    {
        let req = new XMLHttpRequest();
        req.open('POST','insertAjax.php',true);
        req.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
        req.send(
            'name='         + encodeURIComponent($array['username'])      + '&' +
            'email='        + encodeURIComponent($array['email'])         + '&' +
            'delete_pass='  + encodeURIComponent($array['deletepass'])    + '&' +
            'comment='      + encodeURIComponent($array['comment'])       + '&' +
            'thread_id='    + encodeURIComponent($array['thread_id'])     + '&' +
            'res_no='       + encodeURIComponent($array['last_res_no']),
            );
        req.onreadystatechange = function()
        {
            switch(req.readyState)
            {
                case 4:
                    if(req.status == 200)
                    {
                        let result = JSON.parse(req.responseText);
                        resolve(result);
                    }
                    break;
            }
        }
    })
}

function deleteRecode(threadinfo,data)
{
    return new Promise((resolve,reject) =>
    {
        let xhr = new XMLHttpRequest();
        xhr.open('POST','deleteAjax.php',true);
        xhr.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');

        xhr.send(
            'thread_id=' + encodeURIComponent(threadinfo['thread_id']) + '&' + 
            'data='      + encodeURIComponent(data)
        );
    
        xhr.onreadystatechange = function()
        {
            switch(xhr.readyState)
            {
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

function searchRecode(thread_data,data)
{
    return new Promise((resolve,reject) =>
    {
        let xhr = new XMLHttpRequest();
        xhr.open('POST','searchAjax.php',true);
        xhr.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
        xhr.send(
            'thread_id=' + encodeURIComponent(thread_data.threadinfo['thread_id']) + '&' + 
            'data='      + encodeURIComponent(data)
        );
    
        xhr.onreadystatechange = function()
        {
            switch(xhr.readyState)
            {
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

function createCommentDOM(fetchdata,thread_data)
{
   let comment_area = document.querySelector('#main-content');
   let fragment = document.createDocumentFragment();  
   let $form = document.createElement('form');
   $form.classList.add('main-content__form');
   $form.setAttribute("name",'comment_area');

   let response_No = thread_data.responseNo;

   //取得した配列をループで回し、DOMを作成し表示する
   fetchdata.forEach(element => {

        response_No += 1;

        if(element['delete_flg'])
        {
            return;
        }

        //レスのbody部分を作成する
        let $div = document.createElement('div');
        $div.classList.add('main-content__item',element['ID']);

        //削除指定用のチェックボックスを作成
        let $input = document.createElement('input');
        $input.setAttribute("type","checkbox");
        $input.setAttribute("name",'delete_check');
        $input.setAttribute("value",element['ID']);
        $input.classList.add('main-content__checkbox');

        //投稿者名を作成
        let $span_username   = document.createElement('span');
        $span_username.appendChild(document.createTextNode(element['username']));
        $span_username.classList.add('main-content__name');
        
        //投稿時間を作成
        let $span_writingtime = document.createElement('span');
        $span_writingtime.appendChild(document.createTextNode(element['create_data']));
        $span_writingtime.classList.add('main-content__time');

        //レスを作成
        let $p_comment = document.createElement('p');
        $p_comment.appendChild(document.createTextNode(element['comment']));
        $p_comment.classList.add('main-content__text');

        //作成したDOMをbodyタグに挿入
        $div.appendChild($input);
        $div.appendChild($span_username);
        $div.appendChild($span_writingtime);
        $div.appendChild($p_comment);

        //仮想ツリーにbodyを挿入
        fragment.appendChild($div);
   });

   thread_data.responseNo = response_No;

   $form.appendChild(fragment);
   comment_area.appendChild($form);
}

//スレッドデータ管理クラス
class thread
{
    _page_type;
    _thread_id;
    _response_list;
    _last_database_id;
    _last_update_time;
    _last_res_no;

    constructor()
    {
        this._page_type = 'thread'; 
        this._thread_id = 0;
        this._response_list = [];
        this._last_database_id = 0;
        this._last_update_time = null;
        this._last_res_no = 0;
    }

    set threadinfo(array)
    {
        let data = array[array.length - 1]
        this._last_database_id = Number(data['ID']);
        this._last_update_time = data['create_data'];
    }

    get threadinfo()
    {
        let result = [];
        result['page_type']     = this._page_type;
        result['thread_id']     = this._thread_id;
        result['last_database_id']  = this._last_database_id;
        result['last_update_time'] = this._last_update_time;
        return result;
    }

    set responseNo(res_no)
    {
        this._last_res_no = res_no;
    }
    get responseNo()
    {
        return this._last_res_no;
    }
}

