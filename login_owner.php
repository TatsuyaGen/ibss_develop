<?php
include('login_owner_class.php');
$option = new login_owner_class();
//ログインボタンの送信を受け取り、データベースに登録されているpasswordを確認
if(isset($_POST["login"]) && isset($_POST['pass'])){
    $pass = $_POST['pass'];
    $option->password_check($pass);
}
if(isset($_GET['A'])){
    $message = $_GET['A'];
    $option->show_alert($message);
}
?>
<html>
    <head>
      <title>ログイン</title>
      <meta charset="utf-8">
      <link rel = "stylesheet" href="login_owner.css">
    </head>
    <body>
      <h1 class="login-moji">ログイン</h1>
      <form method="post" action="login_owner.php" style="width:1100px;"> 
        <!--パスワード入力フォーム(入力必須)-->
        <input type="password" id="pass_input" name="pass" placeholder = "パスワードを入力">
        <div class="submit_alignment">
          <!--「TOPへ」ボタン(TOPへ移動)-->
          <input type="submit" class="top" name="top" value="TOPへ" onClick="form.action='toppage.php';return true">
          <!--「ログイン」ボタン(login_owner.phpから"login"の送信情報を受け取りパスワード認証を行う)-->
          <input type="submit" class="login" name="login" value="ログイン">
        </div>
      </form>
    </body>
  </html>

