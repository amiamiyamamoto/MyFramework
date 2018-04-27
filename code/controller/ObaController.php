<?php
class ObaController extends BaseController
{
    public function action() {
        //テンプレート取得
        $template = $this->getTemplate('oba.html');
        //タグの置換
        $html = $this->replaceTags($template);
        //userテーブルにインサート
        $db = Database::getPdo();
        $db->prepare("insert into users (name,age) values ('oba', 60)")->execute();
        //画面に表示
        $this->displayHtml($html);
    }
}
