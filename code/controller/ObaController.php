<?php
class ObaController extends BaseController
{
    public function action() {
        $template = $this->getTemplate();
        $html = $this->replaceTags($template);
        $this->renderHtml($html);
    }

    //templateを取得するメソッド
    protected function getTemplate() {
        $template = file_get_contents('../template/oba.html');
        return $template;
    }

    //タグを置換するメソッド
    protected function replaceTags($template) {
        //タグの正規表現
        $pattern = '/{{\s*(\w*)\s*}}/';
        
        //templateから、{{ ◯◯ }}部分を抽出し、配列に格納
        //$tagNum　→　置換したタグの数
        //$tags　→　抽出した{{ ◯◯ }}と、◯◯の部分が配列に格納されている
        $tagNum = preg_match_all($pattern, $template, $tags);
        
        //置換後のテキストを格納する変数
        $replacedTemplate = $template;

        //テンプレ内に含まれているタグを置換する
        for ($i = 0; $i < $tagNum; $i++) {

            //{{◯◯}}の部分
            $tag     = $tags[0][$i];
            //◯◯の部分
            $tagName = $tags[1][$i];

           //タグが、GETで取得されているかを判別する
            if ($_GET[$tagName] == true) {
                //パラメータがある場合はValueに置換する
                $replacedTemplate = str_replace($tag, $_GET[$tagName], $replacedTemplate);
            } else {
                //パラメータがない場合は、空白に置換する
                $replacedTemplate = str_replace($tag, "", $replacedTemplate);
            }
        }
        return $replacedTemplate;
    }

    //htmlを出力するメソッド
    private function renderHtml($html) {
        echo $html;
    }
}
