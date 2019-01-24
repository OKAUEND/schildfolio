<?php

require('function.php');

debug('//---------------------------------------------');
debug('// ログアウト処理');
debug('//---------------------------------------------');
debuglogstart();

debug('セッションを削除');
//セッションを破棄する
session_destroy();

debug('ログインページヘ遷移');
//ログインページに遷移する
header('Location:login.php');