<?php
class menu_add_class{
    private $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
    private $db_username    = 'root';
    private $db_password    = '';

    //get_categoryメソッド...データベースからカテゴリー名を取得
    public function get_category(){
        $pdo = new PDO($this->link, $this->db_username, $this->db_password);
        $sql = "SELECT DISTINCT category FROM menutable";
        $stmt = $pdo->query($sql);
        $categorys = Array();
        while($row = $stmt->fetch()){
            $categorys[] = $row['category']; 
        }
        return $categorys;
    }

    //show_alertメソッド...アラートの表示
    public function show_alert($message){
        $alert = "<script type='text/javascript'>alert('".$message."');</script>";
        echo $alert;
    }
}