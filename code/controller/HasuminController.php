<?php
class HasuminController extends BaseController {
    public function action() {
        //テンプレート取得
        $template = $this->getTemplate('hasumin.html');
        
        //画面に表示
        $this->displayHtml($template);
    }
}
