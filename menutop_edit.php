<?php
include('menutop_edit_class.php');
$option = new menutop_edit_class();
if(isset($_GET['A'])){
    $message = $_GET['A'];
    $option->show_alert($message);
}else if(!isset($_POST['menutop_back'])){
    header("location: login_owner.php?A=".urlencode('不正なアクセスです'));
    return 0;
}

$input_menu_date = $option->get_menudate();
$cateorys = $option->get_category($input_menu_date);
$export_menu_date = $option->get_by_category($input_menu_date,$cateorys);
$menu_date = $option->sorting_menudate($export_menu_date);

//カテゴリー数を保存
$cnt = count($cateorys);
//メニューがデータベースに保存されているかの確認(メニューデータなしにデータベースを参照するとエラーが発生するため)
if($cnt != 0){
    //更新確認画面で「戻る」の送信と、更新データの取得の判断
    //更新データがあれば、更新データを$show配列に保存（メニューの表示に利用する）
    //更新データがなければ、元のメニューデータを保存
    if(isset($_POST["menutop_back"]) && isset($_POST["topback_date"])){
        $show_input = $_POST["topback_date"];
        for($i = 0; $i < count($show_input); $i++){
            $s = explode(",",$show_input[$i]);
            $show[] = $s;
        }
    }else{
        $show = $menu_date;
    }
    $edit_date = $option->get_by_category($show,$cateorys);
}
?>

<html>
  <head>
    <title>選択</title>
    <meta charset="utf-8">
    <link rel = "stylesheet" href="menutop_edit.css">
    <style>
        <?php 
        //タブと表示内容の連携のためのcssコード
        for($h = 0; $h < $cnt; $h++){
            if($h == $cnt - 1){
                echo "#a".$h.":checked ~ #a".$h."_content{display: block;}";
            }else{
                echo "#a".$h.":checked ~ #a".$h."_content,";
            }
        }   
        ?>
    </style>
  </head>
  <body>
    <form method="post" name="menutop">
        <?php 
        //メニューデータがあるか判断する（データがあれば表示）
        if($cnt != 0){
            ?>
            <div class="tabs" style="width:1500px; margin-left: 0;">
            <?php 
            //各カテゴリーごとにタブ用のラジオボタンとラベルを生成する
            for($k = 0; $k < $cnt; $k++){
                $radio = '<input id="a';
                $radio .= $k;
                if($k == 0) $radio .= '" type="radio" name="tab_item" checked>';
                else $radio .= '" type="radio" name="tab_item" >';
                echo $radio;
                $label = '<label class="tab_item" for="a'."$k".'">'.$cateorys[$k].'</label>';
                echo $label;
            }
            //カテゴリーごとにクラスとidを割り振る
            for($i = 0; $i < $cnt; $i++){
                $content = '<div class="tab_content" id="a'.$i.'_content">';
                $content .= '<div class="tab_content_description">'; 
                $content .= '<p class="c-txtsp">';
                echo $content;
                $c = 0;
            
                $editmenu = array();
                $editvalue = array();
        
                echo '<table><tr style="font-size: 30pt;"><td></td><td width="30">メニュー名</td><td width="70">金額</td></tr>';
                for($j = 0; $j < count($edit_date[$i]); $j++){
                    //メニューごとにcheckboxを作成しvalue値にメニュー名を設定(checkboxは削除するメニューを選択するのに利用)
                    $checkbox = '<tr><td style="width:100px; font-size:30px;"><input type="checkbox" name="checkslist[]" value="'.$edit_date[$i][$j][0].'" style="transform: scale(1.5);">';
                    $c++;
                    //checkboxの番号を振っている(01~09,10~)
                    if($c < 10) $checkbox .= " 0{$c}";
                    else $checkbox .= " {$c}";

                    //メニュー名での更新データと元のデータを比較して値が違っていれば、テキストボックスに色を付ける
                    //更新確認画面から更新せずに戻った場合は変更途中の値が入っている
                    //メニュー名の入力情報を$editmenuの配列に保存
                    if($edit_date[$i][$j][0] == $export_menu_date[$i][$j][0]) $checkbox .= '</td><td style="width:'."600px".';"><input type="text" class="A" id="check'.$j.'" name="editmenu[]" value="'.$edit_date[$i][$j][0].'" style="width:500px; background-color: #ffffff;" onchange="name_color_change();" required></td><td style="width:'."300px".';">';
                    else $checkbox .= '</td><td style="width:'."600px".';"><input type="text" class="A" id="check'.$j.'" name="editmenu[]" value="'.$edit_date[$i][$j][0].'" style="width:500px; background-color: #d9f6ff;" onchange="name_color_change();" required></td><td style="width:'."300px".';">';

                    //メニューの金額での更新データと元のデータを比較して値が違っていれば、テキストボックスに色を付ける
                    //更新確認画面から更新せずに戻った場合は変更途中の値が入っている
                    //金額の入力情報を$editvalueの配列に保存
                    if($edit_date[$i][$j][2] == $export_menu_date[$i][$j][2]) $checkbox .= '<input type="int" id="ncheck'.$j.'" name="editvalue[]" value="'.$edit_date[$i][$j][2].'" style="width:300px; background-color: #ffffff;" onchange="value_color_change();" required></td><td style="font-size: 30px;">円</td></tr>';
                    else $checkbox .= '<input type="int" id="checkn'.$j.'" name="editvalue[]" value="'.$edit_date[$i][$j][2].'" style="width:300px; background-color: #d9f6ff;" onchange="value_color_change();" required</td><td style="font-size: 30px;">円</td></tr>';
                    echo $checkbox;
                }
                echo "</table></p></div></div>";
            }
            echo "</div>"
        ?>
            <?php
            //元のデータを一次元配列でhiddenタイプで$moto_date配列に保存
            for($j = 0; $j < count($menu_date); $j++){
                $m_date = array($menu_date[$j][0],$menu_date[$j][1],$menu_date[$j][2]);
                $moto_solo = implode(',', $m_date);
                echo '<input type="hidden" name="moto_date[]" value="'.$moto_solo.'">';
            }
            ?>
        
            <div class="mode_select">
                <!--編集終了ボタン-->
                <input type="submit" name="end" value="終了" onClick="form.action='toppage.php';return true" class="end_submit">
                <!--メニュー削除ボタン-->
                <input type="submit" name="delete_check" value="削除" onClick="form.action='menu_delete.php';return true" class="delete_submit">
                <!--メニュー追加ボタン-->
                <input type="submit" name="add_input" value="追加" onClick="form.action='menu_add.php';return true" class="add_submit">
                <!--メニュー更新ボタン--> 
                <input type="submit" name="edit_check" value="更新" onClick="form.action='menu_edit.php';return true" class="edit_submit">
            </div>
        </form>
        <?php
        }else{ 
        //メニューが登録されていない場合($cnt=0)
        ?>
            <h1>メニューが登録されていません</h1>
            <div class="mode_select"> 
                <!--編集終了ボタン-->
                <input type="submit" name="end" value="終了" onClick="form.action='toppage.php';return true" class="end_submit">
                <!--メニュー追加ボタン-->
                <input type="submit" name="add_input" value="追加" onClick="form.action='menu_add.php';return true" class="add_submit">
            </div>
            <?php 
        }
            ?>
  </body>
</html>
