<?php
class AmiController extends BaseController{
    public function action() {
        //テンプレート取得
        $template = $this->getTemplate('ami.html');
        //タグの置換
        $html = $this->replaceTags($template);
        //dbの処理
        //インサート（Transactionなし）
        $db = DB::getDbInstance();
        //var_dump($db);
        //↓うまくいった
        $db->insert("insert into users (name,age) values ('亜美', 50)");

        //Transaction内
        $db->transaction(function() use ($db) {
            $db->insert("insert into users (name, age) values ('トランザクション太郎', 22)");
            //DB::insert("insert intoooo users (name, age) values('トランザクション次郎', 33)");
        });

        //画面に表示
        $this->displayHtml($html);
    }

    public function __destrucct() {
        echo 'インスタンスが開放されたよ！';
    }
}
