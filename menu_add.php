<?php
include('menu_add_class.php');
$option = new menu_add_class();
$categorys = $option->get_category();
if(isset($_GET['A'])){
    $message = $_GET['A'];
    $option->show_alert($message);
}
if(isset($_POST["backadd_name_check"]) && isset($_POST["backadd_value_check"]) && isset($_POST["back_category"])){
    $show_name = $_POST["backadd_name_check"];
    $show_value = $_POST["backadd_value_check"];
    $select_category = $_POST["back_category"]; 
}else{
    $show_name = array_fill(0,20,"メニュー名");
    $show_value = array_fill(0,20,0);
    $select_category = "shoki";
}
if(!(isset($_POST["add_back"]) || isset($_POST["add_input"]) || isset($_GET["A"]))){
    header("location: login_owner.php?A=".urlencode('不正なアクセスです'));
    return 0;
} 
?>

<html>
  <head>
    <title>追加</title>
    <meta charset="utf-8">
    <link rel = "stylesheet" href="menu_add.css">
    <script type="text/javascript">
      //新規カテゴリーを選択したときのみに入力フォームが表示されるように設定する
      function category_change(){
        if(document.addpage.select_category_input.options[<?php echo count($categorys)+1; ?>].selected){
          document.addpage.newcategory.style.display = "";
        }else{
          document.addpage.newcategory.style.display = "none";
        }  
      }
      window.onload = category_change;
    </script>
  </head>
  <body>
    <h1>追加情報を入力してください</h1>
    <form method="post" name="addpage">
      <?php
      //カテゴリー選択用のセレクトボックスを作成
      echo '<select name="select_category_input" onchange="category_change();">';
      if($select_category == "shoki") echo '<option value="shoki" selected>選択してください</option>';
      else echo '<option value="shoki">選択してください</option>';
      for($i = 0; $i < count($categorys); $i++){
        if($select_category == $categorys[$i]) echo '<option value="'.$categorys[$i].'" selected>' .$categorys[$i]. '</option>';
        else echo '<option value="'.$categorys[$i].'">' .$categorys[$i]. '</option>';
      }
      if(isset($_POST["back_newcategory"])) echo '<option value="newcate" selected>新規</option>';
      else echo '<option value="newcate">新規</option>';
      echo "</select>";
      ?>
            
      <?php
      //新規カテゴリー入力フォーム
      if(isset($_POST["back_newcategory"])) echo '<input class="newcategory" name="newcategory" type="text" value="'.$select_category.'">';
      else echo '<input class="newcategory" name="newcategory" type="text">';
      ?>

      <?php 
      //メニュー名、金額の入力フォーム
      echo '<div class="scroll">';
      $create_table = "";
      $create_table = '<table class="add_table">';
      $create_table .= '<tr style="font-size: 30pt;"><td>メニュー名</td><td>金額</td></tr>';
      for($j = 0; $j < 20; $j++){
        $create_table .= '<tr><td><input class="menu_name" type="text" name="addname[]" placeholder = "メニュー名を入力" value="'.htmlentities($show_name[$j]).'" required></td>';
        $create_table .= '<td><input class="menu_value" type="int" name="addvalue[]" placeholder = "金額を入力" value="'.$show_value[$j].'" required></td></tr>';
      }
      echo $create_table."</table>";
      echo "</div>";
      ?>
      <div class="submit_alignment">
        <!--追加情報確認ボタン(menu_add_check.phpに移る)-->
        <input type="submit" class="add_check" name="add_check" value="確認" onClick="form.action='menu_check_add.php';return true">
        <!--メニュー編集画面に戻るボタン(menutop_edit.phpに移る)-->
        <input type="submit" class="menutop_back" name="menutop_back" value="戻る" onClick="form.action='menutop_edit.php';return true">
      </div>
    </form>
  </body>
</html>