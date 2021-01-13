<?php
class menu_edit_class{
    private $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
    private $db_username    = 'root';
    private $db_password    = '';

    //alert_messageメソッド...アラート文の生成
    public function alert_message($message){
        header("location: menutop_edit.php?A=".urlencode($message));
        return 0;
    }

    //editメソッド...メニューデータの更新を行う
    public function edit($edit_menu,$edit_value,$edit_category,$befor_menu_input){
        //コンマで区切られていた元のデータを$befor_dateに格納していく
        for($i = 0; $i < count($befor_menu_input); $i++){
            $befor_date[] = explode(",",$befor_menu_input[$i]);
        }
        $arrayEdit[] = array();
        //変更するデータ(メニュー名、金額)とカテゴリー名を$arrayEditの配列にまとめていく
        for($i = 0; $i < count($edit_menu); $i++){
            $arrayEdit[$i][] = $edit_menu[$i];
            $arrayEdit[$i][] = $edit_category[$i];
            $arrayEdit[$i][] = $edit_value[$i];
        }
        $pdo = new PDO($this->link, $this->db_username, $this->db_password);
        //UPDATE SETのSQL文を使用して、元のメニューデータと異なるデータを更新していく
        for($i = 0; $i < count($edit_menu); $i++){
            if(!($arrayEdit[$i][0] == $befor_date[$i][0] && $arrayEdit[$i][1] == $befor_date[$i][1] && $arrayEdit[$i][2] == $befor_date[$i][2])){
                $sql = 'UPDATE menutable SET productname = "'.$arrayEdit[$i][0].'", category = "'.$arrayEdit[$i][1].'", value = "'.$arrayEdit[$i][2].'" WHERE productname = "'.$befor_date[$i][0].'" AND category = "'.$befor_date[$i][1].'" AND value = "'.$befor_date[$i][2].'";';
                $stmt = $pdo->query($sql);
            }
        }
        $this->alert_message('メニュー情報を更新しました');
    }

    //check_editメソッド...入力されたメニュー名、金額が適切かどうか判断
    public function check_edit($editcheck_menu,$editcheck_value,$moto_date_input){
        //$edit_check...メニュー名か金額のどちらかが変更されているか判定するための変数
        $edit_check = true;
        //$moto_date_inputに格納されているデータからコンマを外し、配列にして、$moto_dateに格納していく
        for($i = 0; $i < count($moto_date_input); $i++){
            $moto_date[] = explode(",",$moto_date_input[$i]);
        }
        for($i = 0; $i < count($moto_date); $i++){
            //メニュー名と金額が規則通りに設定されているか確認する(メニュー名は15字以内、金額は1万円以内)
            if(preg_match("/[".preg_quote("!#$%()*+./:;=?@[]^_`{|}<>',&","/")."]/",$editcheck_menu[$i]) || strpos($editcheck_menu[$i],'"') !== false || strpos($editcheck_menu[$i],'-') !== false || strpos($editcheck_menu[$i],' ') !== false || strpos($editcheck_menu[$i],'　') !== false || strpos($editcheck_menu[$i],'~') !== false){
                $this->alert_message('メニュー名に不正な文字が利用されています');
                return true; 
            }else if(preg_match('/[^0-9]{1,}/u',$editcheck_value[$i]) || (int)$editcheck_value[$i] == 0){
                $this->alert_message('金額は半角の正整数で入力してください');
                return true;
            }else if(mb_strlen($editcheck_menu[$i]) > 15){
                $this->alert_message('メニュー名は１５文字以内で入力してください');
                return 0;
            }else if($editcheck_value[$i] >= 10000000){
                $this->alert_message('金額は１０００万円未満で入力してください');
                return 0;
            }
            //メニュー名か金額に変更があるか確認する(変更があれば$edit_check変数をfalseに設定)
            if($moto_date[$i][0] != htmlentities($editcheck_menu[$i]) || $moto_date[$i][2] != $editcheck_value[$i]){
                $edit_check = false; 
            }
            //メニュー名に重複がないか確認している
            for($j = 0; $j < count($editcheck_menu); $j++){
                if($i != $j && $moto_date[$i][0] == htmlentities($editcheck_menu[$j])){
                    $this->alert_message('同じメニュー名が存在しています');
                    return 0;
                }
            }
        }
        //変更がない場合のアラート表示
        if($edit_check){
            $this->alert_message('変更がされていません');
        }
        return $moto_date;
    }

    //editsaveメソッド...「戻る」ボタンで戻った際にmemutop_edit.phpに引き渡す変更データを格納する
    public function editsave($editcheck_menu,$moto_date,$editcheck_value){
        for($i = 0; $i < count($moto_date); $i++){
            //$solo_date...1つの変更データの配列(メニュー名,カテゴリー名,金額)を生成
            $solo_date = array($editcheck_menu[$i],$moto_date[$i][1],$editcheck_value[$i]);
            //$solo_dateのデータをコンマで区切って、$topbackに格納して、$topback_dateの配列に格納していく
            $topback = implode(',', $solo_date);
            echo '<input type="hidden" name="topback_date[]" value="'.htmlentities($topback).'">';
        }
    }
}