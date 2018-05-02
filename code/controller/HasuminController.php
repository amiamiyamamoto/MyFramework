<?php
class HasuminController extends DbConnectController{
    public function dbAction() {
        //テンプレート取得
        $template = $this->getTemplate('hasumin.html');
        //dbの処理
        $this->query("insert into users (name,age) values ('hasukon', 50)");
        $this->query("aaaaaaainsert into users (name,age) values ('hasukon', 50)");
        //画面に表示
        $this->displayHtml($template);
    }
}
