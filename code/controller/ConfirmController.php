<?php
class ConfirmController extends BaseController{
    public function action() {
        //テンプレート取得
        $template = $this->getTemplate('input.html');

        var_dump($_POST);
        //画面に表示
        $this->displayHtml(implode($_POST));
    }

}
