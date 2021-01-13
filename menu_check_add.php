<?php
include('menu_check_add_class.php');
$option = new menu_check_add_class();
$menu_name = $option->get_menuname();
$cnt = count($menu_name);

//追加処理
if(isset($_POST["add"]) && isset($_POST["addname_check"]) && isset($_POST["addvalue_check"]) && isset($_POST["select_category"])){
    $addname_check = $_POST['addname_check'];
    $addvalue_check = $_POST['addvalue_check'];
    $select_category = $_POST['select_category'];
    $option->add($addname_check,$addvalue_check,$select_category);
    return 0;
}else if(!isset($_POST["add_check"])){
    header("location: login_owner.php?A=".urlencode('不正なアクセスです'));
    return 0;
} 

?>

<html>
    <head>
        <title>追加確認</title>
        <meta charset="utf-8">
        <link rel = "stylesheet" href="menu_check_add.css">
        <script>

        </script>
    </head>
    <body>
        <form method="post">
            <h1>以下を追加しますか</h1>
            <?php
            $newcategory_back = "";
            if(isset($_POST["add_check"]) && isset($_POST["select_category_input"])){
                $select_state = $_POST["select_category_input"];
                if($select_state == "shoki"){
                    $option->alert_message('カテゴリーを選択してください');
                    return 0;
                }else if($select_state == "newcate"){
                    if(isset($_POST["newcategory"])){
                        //「newcate」状態を$sc_backに保存
                        $newcategory_back = $select_state;
                        //新規カテゴリー名に更新される 
                        $select_state = $_POST["newcategory"];
                        if($option->category_check($select_state)) return 0; 
                    }else{
                        $option->alert_message('追加エラーです');
                        return 0;
                    }
                }
            
                if(isset($_POST['addname']) && isset($_POST['addvalue'])){
                    $addname[] = $_POST['addname'];
                    $addvalue[] = $_POST['addvalue'];
                    $select_category = $select_state;
                    $check_add = 0;
                    for($i = 0; $i < count($addname[0]); $i++){
                        if($option->solo_datecheck($addname[0][$i],$addvalue[0][$i],$menu_name)){
                            $check_add = 1;
                            break;
                        }
                        //入力したメニュー名同士の比較
                        if($option->solo_samedatecheck($addname,$i)){
                            $check_add = 1;
                            break;
                        } 

                        if($addname[0][$i] != "メニュー名" && $addvalue[0][$i] != 0){
                            $addname_check[] = $addname[0][$i];
                            $addvalue_check[] = $addvalue[0][$i] % 10000000;
                            echo '<input type="hidden" name="select_category" value="'.htmlentities($select_category,ENT_QUOTES,"UTF-8").'">';
                            echo '<input type="hidden" name="addname_check[]" value="'.htmlentities($addname[0][$i],ENT_QUOTES,"UTF-8").'">';
                            echo '<input type="hidden" name="addvalue_check[]" value="'.htmlentities($addvalue[0][$i],ENT_QUOTES,"UTF-8").'">';
                            $check_add++;
                        }
                    }
                    //追加するデータが入力されていない
                    if($check_add == 0){
                        $option->alert_message('追加情報を入力してください');
                        return 0;
                    } 
                }else{
                    $option->alert_message('追加エラーです');
                    return 0;
                }
            }else{
                header("location: login_owner.php?A=".urlencode('不正なアクセスです'));
                return 0;
            }
            ?>

            <?php
            //追加内容の表示
            echo '<div class="cate">カテゴリ名：'.htmlentities($select_state,ENT_QUOTES,"UTF-8")."</div>";
            echo '<div class="scroll">';
            $show_add = "<table class='add_menu'>";
            $show_add .= '<tr style="font-size: 50px";><td>メニュー名</td>'."<td>金額</td></tr>";
            
            for($j = 0; $j < count($addname_check); $j++){
                $show_add .= '<tr><td style="width: 750px;">'.htmlentities($addname_check[$j],ENT_QUOTES,"UTF-8")."</td>";
                $show_add .= '<td style="width: 350px;">'.htmlentities($addvalue_check[$j],ENT_QUOTES,"UTF-8")."円</td></tr>";
            }
            $show_add .= "</table>";
            echo $show_add;
            echo "</div>";
            $option->backsave($select_state,$addname,$addvalue,$newcategory_back);
            ?>
            <div class="submit_alignment">
                <!--追加ボタン-->
                <input type="submit" class="add" name="add" value="追加" onClick="form.action='menu_check_add.php';return true">
                <!--戻るボタン(menu_add.phpに移る)-->
                <input type="submit" class="add_back" name="add_back" value="戻る" onClick="form.action='menu_add.php';return true">
            </div>
        </form>
    </body>
</html>