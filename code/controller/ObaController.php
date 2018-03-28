<?php
class ObaController extends BaseController
{
    public function action() {
        //テンプレート取得
        $template = $this->getTemplate('oba.html');
        //タグの置換
        $html = $this->replaceTags($template);
        //画面に表示
        $this->display($html);
    }
}
