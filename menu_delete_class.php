<?php
class menu_delete_class{
    private $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
    private $db_username    = 'root';
    private $db_password    = '';

    //deleteメソッド...メニューデータの削除を行う
    public function delete($delete_menu){
        $pdo = new PDO($this->link, $this->db_username, $this->db_password);
        $inClause = substr(str_repeat(',?', count($delete_menu)), 1);
        $sql = "DELETE FROM menutable WHERE productname IN ({$inClause})";
        $stmt = $pdo->prepare($sql);
        $stmt -> execute($delete_menu);
        $this->alert_message('メニュー情報を削除しました');
    }

    //alert_messageメソッド...アラート文の生成
    public function alert_message($message){
        header("location: menutop_edit.php?A=".urlencode($message));
        return 0;
    }

    //get_delete_dateメソッド...削除するメニューのメニューデータを取得
    public function get_delete_date($checklist){
        $pdo = new PDO($this->link, $this->db_username, $this->db_password);
        $inClause = substr(str_repeat(',?', count($checklist)), 1);
        $sql = "SELECT * FROM menutable WHERE productname IN ({$inClause})";
        $stmt = $pdo->prepare($sql);
        $stmt -> execute($checklist);
        while($row = $stmt->fetch()){
            $delete_input[] = $row;
        }
        return $delete_input;
    }

    //get_delete_categoryメソッド...削除するメニューのカテゴリー名を格納する
    public function get_delete_category($delete_input){
        for($i = 0; $i < count($delete_input); $i++) $tmp[] = $delete_input[$i]["category"]; 
        $categorys = array_values(array_unique($tmp));
        return $categorys;
    }

    //get_by_categoryメソッド...カテゴリーごとにメニューデータを配列に格納
    public function get_by_category($input_array,$categorys){
        $output_array[] = array();
        for($i = 0; $i < count($categorys); $i++) for($j = 0; $j < count($input_array); $j++) if($input_array[$j][1] == $categorys[$i]) $output_array[$i][] = $input_array[$j];
        return $output_array;
    }

    //sorting_menudateメソッド...カテゴリーごとにメニューデータを並べ替え
    public function sorting_menudate($export_menu_date){
        for($i = 0; $i < count($export_menu_date); $i++){
            for($j = 0; $j < count($export_menu_date[$i]); $j++){
                $menu_date[] = $export_menu_date[$i][$j];
            }
        }
        return $menu_date;
    }
}