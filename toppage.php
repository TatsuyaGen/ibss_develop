<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TOPページ</title>
    </head>
    <body>
    <h1>IBSS</h1>
    <form id="top_page" name="top_page" action="" method="POST">
        <div>
        <button class="order_input">注文受付</button>
        <button class="order_input">座席状況</button>
        <button class="order_input">注文管理</button>
        <button class="order_input" style="margin-left: 310px;">会計</button>
        <button class="order_input" formaction="login_owner.php">メニュー編集</button>  
        </div>
    </form>
    <style>
h1{
    font-size:60px;
}
body{
    width: 1500px;
}
        .order_input {
    width: 400px;
    height:160px;
    font-size: 50px;
    /*position: relative;*/
    margin: 0px 40px 100px;
    display: inline-block;
    padding: 0.25em 0.5em;
    text-decoration: none;
    color: #FFF;
    background: #fd9535;/*色*/
    border-radius: 4px;/*角の丸み*/
    box-shadow: inset 0 2px 0 rgba(255,255,255,0.2), inset 0 -2px 0 rgba(0, 0, 0, 0.05);
    font-weight: bold;
    border: solid 2px #d27d00;/*線色*/
    float:left;
    }

    .btn-square-so-pop:active {
    /*押したとき*/
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.30);
    }
    </style>
    </body>
</html>