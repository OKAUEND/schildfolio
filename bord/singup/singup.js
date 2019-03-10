window.addEventListener("load",function (){

    let email = document.querySelector("#email_input");

    email.addEventListener("keyup",function()
    {
        let email_txt = this.value;
        let wait_aysc = false;
        if(email_txt && !wait_aysc)
        {
            let req = new XMLHttpRequest();

            req.onreadystatechange = function()
            {
                if(req.readyState == 4 && req.status == 200)
                {
                    let data = eval('(' + this.responseText + ')');
                    let mes_area = document.querySelector("#email-js") 
                    console.log(data);
                    if(data)
                    {
                        mes_area.classList.remove('email-error');
                        mes_area.classList.add('email-success');
                        mes_area.textContent = 'Emailの入力';
                    }
                    else
                    {
                        //警告を発するために、文字列とタグの変更
                        mes_area.classList.remove('email-success');
                        mes_area.classList.add('email-error');
                        mes_area.textContent = 'Emailを正しく入力してください。';
                    }
                    wait_aysc = false;
                }
                else
                {
                    wait_aysc = true;
                }
            }

            req.open("POST", 'singupAjax.php',true);
            req.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
            req.send('vali_input=' + encodeURIComponent('true') + '&' + 'email=' + encodeURIComponent(email_txt));
        }
        else if(email_txt.length == 0)
        {
            let mes_area = document.querySelector("#email-js") 
            mes_area.classList.remove('-error','-success');
            mes_area.textContent = '';
        }
    },false);

},false);