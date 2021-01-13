<?php
class menutop_edit_class{
    private $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
    private $db_username    = 'root';
    private $db_password    = '';

    //show_alertメソッド...アラートの表示
    public function show_alert($message){
        $alert = "<script type='text/javascript'>alert('".$message."');</script>";
        echo $alert;
    }

    //get_menudateメソッド...全メニューデータを取得
    public function get_menudate(){
        $pdo = new PDO($this->link, $this->db_username, $this->db_password);
        $sql = "SELECT * FROM menutable";
        $stmt = $pdo->query($sql);
        //$input_menu_date...メニューデータを１つづつ保存していくための配列
        $input_menu_date = Array();
        while($row = $stmt->fetch()){
            $input_menu_date[] = $row;
        }
        return $input_menu_date;
    }

    //get_categoryメソッド...カテゴリー名を取得する
    public function get_category($input_menu_date){
        $tmp = Array();
        for($i = 0; $i < count($input_menu_date); $i++) $tmp[] = $input_menu_date[$i]["category"]; 
        $categorys = array_values(array_unique($tmp));
        return $categorys;
    }

    //sorting_menudateメソッド...カテゴリーごとにメニューデータを並べ替え
    public function sorting_menudate($export_menu_date){
        $menu_date = Array();
        for($i = 0; $i < count($export_menu_date); $i++){
            for($j = 0; $j < count($export_menu_date[$i]); $j++){
                $menu_date[] = $export_menu_date[$i][$j];
            }
        }
        return $menu_date;
    }

    //get_by_categoryメソッド...カテゴリーごとにメニューデータを配列に格納
    public function get_by_category($input_array,$cateorys){
        $output_array[] = array();
        for($i = 0; $i < count($cateorys); $i++) for($j = 0; $j < count($input_array); $j++) if($input_array[$j][1] == $cateorys[$i]) $output_array[$i][] = $input_array[$j];
        return $output_array;
    }
}
?>