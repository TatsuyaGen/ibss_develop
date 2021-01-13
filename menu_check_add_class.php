<?php
class menu_check_add_class{
    private $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
    private $db_username    = 'root';
    private $db_password    = '';

    //get_menunameメソッド...データベースから全メニューのメニュー名を取得
    public function get_menuname(){
        $pdo = new PDO($this->link, $this->db_username, $this->db_password);
        $sql = "SELECT * FROM menutable";
        $stmt = $pdo->query($sql);
        $cnt = 0;
        while($row = $stmt->fetch()){
            $cnt++; 
            $menu_name[] = $row['productname'];
        }
        //データがなければ空データ
        if($cnt == 0){
            $menu_name = NULL;
            $menu_name = array();
        }
        return $menu_name;
    }

    //addメソッド...メニューの追加処理
    public function add($addname_check,$addvalue_check,$select_category){
        //追加するメニューデータを$arrayAdd配列に格納する
        $arrayAdd[] = array();
        for($i = 0; $i < count($addname_check); $i++){
            $arrayAdd[$i] = '("'.$addname_check[$i].'", "'.$select_category.'", "'.$addvalue_check[$i].'")';
        }
        $pdo = new PDO($this->link, $this->db_username, $this->db_password);
        $sql = "INSERT INTO menutable (productname, category, value) VALUES" .join(",", $arrayAdd);
        $stmt = $pdo->query($sql);
        header("location: menutop_edit.php?A=".urlencode('メニュー情報を追加しました'));
        return 0;
    }

    //alert_messageメソッド...アラート文の生成
    public function alert_message($message){
        header("location: menu_add.php?A=".urlencode($message));
        return 0;
    }

    //category_checkメソッド...新規で入力したカテゴリー名が適切かどうか判断
    public function category_check($select_state){
        //新規カテゴリー名が入力されているかぼ判定
        if($select_state == ""){
            $this->alert_message('新規カテゴリー名を入力してください');
            return true;
        //新規カテゴリー名の長さ
        }else if(mb_strlen($select_state) > 14){
            $this->alert_message('新規カテゴリー名は14文字以下で入力してください');
            return true;
        //入力値による攻撃の対策
        }else if(preg_match("/[".preg_quote("!#$%()*+./:;=?@[]^_`{|}<>',&","/")."]/",$select_state) || strpos($select_state,'"') !== false || strpos($select_state,'-') !== false || strpos($select_state,' ') !== false || strpos($select_state,'　') !== false || strpos($select_state,'~') !== false){
            $this->alert_message('新規カテゴリーに不正な文字が利用されています');
            return true;
        }
        return false;
    }

    //solo_datecheckメソッド...メニュー名、金額の入力が適切かどうかの判断
    public function solo_datecheck($addname,$addvalue,$menu_name){
        $cnt = count($menu_name);
        if($addname == "メニュー名"){
            //メニュー名が"メニュー名"かつ金額が0(どちらも入力されていない)ときは無視する
            if($addvalue == 0){
                return false;
            }else{
                $this->alert_message('金額だけ入力されている欄があります');
                return true;
            }
        //金額が範囲以内か判定
        }else if($addvalue >= 10000000){
            $this->alert_message('金額は1000万円未満で入力してください');
            return true;
        //メニュー名の長さの判定
        }else if(mb_strlen($addname) > 15){
            $this->alert_message('メニュー名は15文字以下で入力してください');
            return true;
        //金額の入力値の判定
        }else if(preg_match('/[^0-9]{1,}/u',$addvalue) || (int)$addvalue == 0){
            $this->alert_message('金額は半角の正整数で入力してください');
            return true;
        //すでに登録されているメニュー名と入力したメニュー名の比較
        }else if($cnt != 0) for($j = 0; $j < count($menu_name); $j++) if($menu_name[$j] == $addname){
            $this->alert_message('同じメニュー名が存在しています');
            return true;
        }
        //入力値による攻撃の対策
        if(preg_match("/[".preg_quote("!#$%()*+./:;=?@[]^_`{|}<>',&","/")."]/",$addname) || strpos($addname,'"') !== false || strpos($addname,'-') !== false || strpos($addname,' ') !== false || strpos($addname,'　') !== false || strpos($addname,'-') !== false || strpos($addname,'~') !== false ){
            $this->alert_message('メニュー名に不正な文字が利用されています');
            return true; 
        }
        return false;
    }

    //solo_samedatecheckメソッド...入力したメニュー名同士が重複していないか判断
    public function solo_samedatecheck($addname,$i){
        for($j = 0; $j < count($addname[0]); $j++) if($i != $j && $addname[0][$i] != "メニュー名" && $addname[0][$i] == $addname[0][$j]){
            $this->alert_message('追加するメニュー名が重複しています');
                return true;
        }
        return false;
    }
    
    //backsaveメソッド...menu_add.phpで入力データを表示するための配列を生成
    public function backsave($select_state,$addname,$addvalue,$newcategory_back){
        echo '<input type="hidden" name="back_category" value="'.$select_state.'">';
        for($i = 0; $i < count($addname[0]); $i++){
            echo '<input type="hidden" name="backadd_name_check[]" value="'.htmlentities($addname[0][$i],ENT_QUOTES,"UTF-8").'">';
            echo '<input type="hidden" name="backadd_value_check[]" value="'.htmlentities($addvalue[0][$i],ENT_QUOTES,"UTF-8").'">';
        }
        //新規カテゴリー名の入力を保持するための変数
        if($newcategory_back != ""){
            echo '<input type="hidden" name="back_newcategory" value="'.htmlentities($newcategory_back).'">';
        }
    }
}