<?php
trait Validation
{

    public $request;
    public $error = [];

    public function __construct()
    {
        if (!empty($_POST)) {
            $this->request = $_POST;
            $this->validate();
        }
    }

    protected function validate()
    {
        $req = $this->request;
        //validation定義fileを読み込む
        $valid = require_once('../validation/validation.php');

        //リクエストされているキー名を取りだす
        $request_keys = array_keys($req);

        foreach ($request_keys as $key_name) {
            //require判定
            if (array_key_exists('require', $valid[$key_name])) {
                if ($req[$key_name] == '') {
                    $this->error[] = $key_name . 'は必須です<br>';
                }
            }
            //文字列の場合
            if ($valid[$key_name][0] == 'string') {
                //マックス文字列
                if (array_key_exists('max', $valid[$key_name])) {
                    if (mb_strlen($req[$key_name]) > $valid[$key_name]['max']) {
                        $this->error[] = $key_name . 'の文字数が' . $valid[$key_name]['max'] . '文字を超えています<br>';
                    }
                }
                //min文字
                if (array_key_exists('min', $valid[$key_name])) {
                    if (mb_strlen($req[$key_name]) < $valid[$key_name]['min']) {
                        $this->error[] = $key_name . 'は' . $valid[$key_name]['min'] . '文字以上入力してください<br>';
                    }
                }
            }

            //数値の場合
            if ($valid[$key_name][0] == 'number') {
                //数値が入ってない
                if (is_numeric($rep[$key_name])) {
                    $this->error[] = '数値を入力してください';
                }
                //マックス
                if (array_key_exists('max', $valid[$key_name])) {
                    if ($req[$key_name] > $valid[$key_name]['max']) {
                        $this->error[] = $key_name . 'に' . $valid[$key_name]['max'] . 'を超えた数値が入力されています<br>';
                    }
                }
                //min
                if (array_key_exists('min', $valid[$key_name])) {
                    if ($req[$key_name] < $valid[$key_name]['min']) {
                        $this->error[] = $key_name . 'は' . $valid[$key_name]['min'] . '以下の数値を入力してください<br>';
                    }
                }
            }
        }
    }

}