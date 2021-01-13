<?php
include('menu_delete_class.php');
$option = new menu_delete_class();
if(isset($_POST["delete"]) && isset($_POST["delete_menu"])){
    $delete_menu = $_POST["delete_menu"];
    $option->delete($delete_menu);
}else if(!isset($_POST["delete_check"])){
    header("location: login_owner.php?A=".urlencode('不正なアクセスです'));
    return 0;
}else if(isset($_POST["delete_check"]) && isset($_POST["checkslist"]) && $_POST["checkslist"] != NULL){ 
    //削除チェックボックスに保存されたメニュー名からメニューデータを取得
    $checklist = $_POST['checkslist'];
    $delete_input = $option->get_delete_date($checklist);
    $categorys = $option->get_delete_category($delete_input);
}else{
    $option->alert_message('削除するメニューを選択してください');
}


?>
<html>
    <head>
        <title>削除</title>
        <meta charset="utf-8">
        <link rel = "stylesheet" href="menu_delete.css">
    </head>
    <body>
        <h1>これらのメニューを削除しますか</h1>
        <form method="post">
            <?php 
            //delete_bycate...カテゴリーごとに削除するメニューデータを格納
            $delete_bycate = $option->get_by_category($delete_input,$categorys);
            //delete_date...削除するメニュー名を格納した配列
            $delete_date = $option->sorting_menudate($delete_bycate);
            echo '<div class="scroll">';
            $setcategory = "";
            $show_delete = '<table class="delete_menu">';
            for($i = 0; $i < count($delete_date); $i++){
                if($setcategory != $delete_date[$i]['category']){
                    $show_delete .=  '<tr><td colspan="2" style="font-size: 50px; text-align: center;">カテゴリー名：'.$delete_date[$i]['category']."</td></tr>";
                    $show_delete .= '<tr style="font-size: 40px";><td>メニュー名</td><td>金額</td></tr>';
                    $setcategory = $delete_date[$i]['category'];
                }
                $show_delete .= '<tr><td style="width:750px;">'.$delete_date[$i]['productname'].'</td><td style="width:250px;">'.$delete_date[$i]['value']."円</td></tr>";
                $delete_menu[] = $delete_date[$i]['productname'];
            }
            $show_delete .= "</table>";
            echo $show_delete;
            echo '</div>';
            for($d = 0; $d < count($delete_menu); $d++){
                echo '<input type="hidden" name="delete_menu[]" value="'.$delete_menu[$d].'">';
            }   
            ?>
            <div class="submit_alignment">
                <input type="submit" name="delete" class="delete" value="削除" onClick="form.action='menu_delete.php';return true">
                <input type="submit" name="menutop_back" class="menutop_back" value="戻る" onClick="form.action='menutop_edit.php';return true">
            </div>
        </form>
    </body>
</html>