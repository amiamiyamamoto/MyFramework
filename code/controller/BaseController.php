<?php

abstract class BaseController {

    //route.phpからコントローラにアクセスするためのメソッド
    abstract protected function action();

    //templateを呼び出すメソッド
    abstract protected function getTemplate();
    
    //タグを置換するメソッド
    //abstract protected function replaceTags();

    //htmlを返すメソッド
    //abstract protected function getHtml();
}
