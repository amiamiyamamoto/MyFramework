<?php

abstract class BaseController {

    //描画するhtmlを格納するプロパティ
    private $html = '';
    private $statusCode = '200';
    public $request;
    public $error = [];


    //route.phpからコントローラにアクセスするための抽象メソッド
    abstract protected function action();

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

    /**
     * templateを取得するメソッド
     *
     * @param $fileName string テンプレートのファイル名
     * @return string
     */
    protected function getTemplate($fileName) {
        return file_get_contents('../template/'.$fileName);
    }

    /**
     * タグを置換するメソッド
     * 
     * @param $template string
     * @return　string 置換後の文字列
    */ 
    protected function replaceTags($template) {
        
        //タグの正規表現
        $pattern = '/{{\s*(\w*)\s*}}/';
        
        //templateから、{{ ◯◯ }}部分を抽出し、配列に格納
        //$tagNum→見つかったタグの数
        //$tags→抽出した{{ ◯◯ }}と、◯◯の部分が配列に格納されている
        $tagNum = preg_match_all($pattern, $template, $tags);
        
        //テンプレ内に含まれているタグを置換する
        for ($i = 0; $i < $tagNum; $i++) {

            //{{◯◯}}の部分
            $tag     = $tags[0][$i];
            //◯◯の部分
            $tagName = $tags[1][$i];

           //タグが、GETで取得されているかを判別する
            if ($_GET[$tagName] == true) {
                //パラメータがある場合はValueに置換する
                $template = str_replace($tag, $_GET[$tagName], $template);
            } else {
                //パラメータがない場合は、空白に置換する
                $template = str_replace($tag, "", $template);
            }
        }
        return $template;
    }

    /**
     * htmlプロパティに値を格納するメソッド
     *
     * @param $html string
     */
    protected function displayHtml($html) {
        $this->html = $html;
    }

    //statusCodeプロパティに値を格納するメソッド
    protected function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
    }

    //htmlを返すメソッド
    public function getHtml() {
        return $this->html;
    }

    //ステータスコードを返すメソッド
    public function getStatusCode() {
        return $this->statusCode;
    }
    
}
