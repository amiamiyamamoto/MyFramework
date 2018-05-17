<?php

abstract class BaseController {

    //描画するhtmlを格納するプロパティ
    private $html = '';
    private $statusCode = '200';

    //route.phpからコントローラにアクセスするための抽象メソッド
    abstract protected function action();

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
