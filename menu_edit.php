<?php
include('menu_edit_class.php');
$option = new menu_edit_class();
if(isset($_POST["edit"]) && isset($_POST["edit_menu"]) && isset($_POST["edit_value"]) && isset($_POST["edit_category"])){
    $edit_menu = $_POST['edit_menu'];
    $edit_value = $_POST['edit_value'];
    $edit_category = $_POST['edit_category'];
    $befor_menu_input = $_POST['befor_menu'];
    $option->edit($edit_menu,$edit_value,$edit_category,$befor_menu_input);
}else if(isset($_POST["edit_check"])){//従来のデータから変更があるか、そもそもデータがあるかの確認処理
    if(isset($_POST["editmenu"]) && isset($_POST["editvalue"]) && isset($_POST["moto_date"])){
        $editcheck_menu = $_POST["editmenu"];
        $editcheck_value = $_POST["editvalue"];
        $moto_date_input = $_POST["moto_date"];
        $moto_date = $option->check_edit($editcheck_menu,$editcheck_value,$moto_date_input);
    }else{
        //メニューデータが受け取れなかった場合のアラート表示
        $option->alert_message('メニューデータがありません');
    }  
//menutop_edit.phpの更新ボタンを介さず、menu_edit.phpを開いた場合のアラート表示
}else if(!isset($_POST["edit_check"])){
    header("location: login_owner.php?A=".urlencode('不正なアクセスです'));
    return 0;
}
?>
<html>
    <head>
        <title>更新</title>
        <meta charset="utf-8">
        <link rel = "stylesheet" href="menu_edit.css">
    </head>
    <body>
        <h1>これらのメニューを更新しますか</h1>
        <form method="post"> 
            <?php
                $show_category="";
                $show_table = '<table class="edit_table">';
                echo '<div class="scroll">';
                for($i = 0; $i < count($moto_date); $i++){
                    //更新内容の表示
                    if($moto_date[$i][0] != $editcheck_menu[$i] || $moto_date[$i][2] != $editcheck_value[$i]){
                        if($moto_date[$i][1] != $show_category){
                            $show_category = $moto_date[$i][1];
                            $show_table .= '<tr><td colspan="3" style="font-size: 50px; text-align: center;">カテゴリー名：'.$show_category.'</td></tr>';
                            $show_table .= '<tr style="font-size: 40px;"><td style="width:100px;"></td><td style="width:750px;">メニュー名</td><td style="width:250px;">金額</td></tr>';
                        }
                        //tableで変更前後のメニュー名と金額を表示
                        $show_table .= '<tr><td style="width:125px;">変更前</td><td style="width:750px;">'.htmlentities($moto_date[$i][0]).'</td><td style="width:250px;">'.htmlentities($moto_date[$i][2]).'円</td></tr>';
                        $show_table .= '<tr><td style="width:125px;">変更後</td><td style="width:750px;">'.htmlentities($editcheck_menu[$i]).'</td><td style="width:250px;">'.htmlentities($editcheck_value[$i] % 10000000).'円</td></tr>';
                        $solo_befor_date = array($moto_date[$i][0],$moto_date[$i][1],$moto_date[$i][2]);
                        //hiddenタイプの配列を生成して更新データと元のデータを格納する
                        $befor_date = implode(',', $solo_befor_date);
                        echo '<input type="hidden" name="befor_menu[]" value="'.htmlentities($befor_date).'">';
                        echo '<input type="hidden" name="edit_menu[]" value="'.htmlentities($editcheck_menu[$i]).'">';
                        echo '<input type="hidden" name="edit_value[]" value="'.htmlentities($editcheck_value[$i]).'">';
                        echo '<input type="hidden" name="edit_category[]" value="'.htmlentities($moto_date[$i][1]).'">';
                    }
                }
                echo $show_table;
                echo "</table></div>";
                $option->editsave($editcheck_menu,$moto_date,$editcheck_value);
            ?>
            <div class="submit_alignment">
                <input type="submit" class="edit" name="edit" value="更新" onClick="form.action='menu_edit.php';return true">
                <input type="submit" class="menutop_back" name="menutop_back" value="戻る" formaction="menutop_edit.php">
            </div>
        </form>
    </body>
</html>