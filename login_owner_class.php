<?php 
class login_owner_class{
    private $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
    private $db_username    = 'root';
    private $db_password    = '';

    //password_checkメソッド...パスワードの入力値の照合
    public function password_check($pass){
        $check = false;
        $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
        $pdo = new PDO($this->link, $this->db_username, $this->db_password);
        $sql = "SELECT * FROM ownerinfo";
        $stmt = $pdo->query($sql);
        while($row = $stmt->fetch()){
            //passwordの確認(id=0(管理者)かつ登録されたパスワードの確認)
            if($row['id'] == 0 && htmlspecialchars($row['password'],ENT_QUOTES,'UTF-8') == $pass){
                $check = true;
            }
        }
        if($check) header("location: menutop_edit.php?A=".urlencode("ログインできました"));
        else $this->alert_message('もう一度入力してください');
    }

    //alert_messageメソッド...アラート文の生成
    public function alert_message($message){
        header("location: login_owner.php?A=".urlencode($message));
        return 0;
    }

    //show_alertメソッド...アラートの表示
    public function show_alert($message){
        $alert = "<script type='text/javascript'>alert('".$message."');</script>";
        echo $alert;
    }
}
?>