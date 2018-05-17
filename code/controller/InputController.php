<?php
class InputController extends BaseController{
    use Validation;
    public function action() {
        //テンプレート取得
        $template = $this->getTemplate('input.html');
        $error = implode($this->error);
        $template .= $error;

//        var_dump($this->request);

        //画面に表示
        $this->displayHtml($template);
    }
}
