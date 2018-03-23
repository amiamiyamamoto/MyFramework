<?php

//テンプレートを取得
$template = file_get_contents('../template/hasumin.html');

//templateから取得したい部分{{}}の正規表現
$pattern = '/{{\s*(\w*)\s*}}/';

//template内の{{ ◯◯ }}部分を配列に入れる
$tagNum = preg_match_all($pattern, $template, $tags);

//置換後のテキストを格納する変数
$replacedTemplate = $template;

//テンプレ内に含まれているタグを置換する
for ($i = 0; $i < $tagNum; $i++) {

    $tag     = $tags[0][$i];//タグの名前
    $tagName = $tags[1][$i];//{{}}付きのタグ

    //タグが、GETで取得されているかを判別する
    if ($_GET[$tagName] == true) {

        //パラメータがある場合はValueに置換する
        $replacedTemplate = str_replace($tag, $_GET[$tagName], $replacedTemplate);
    } else {

        //パラメータがない場合は、空白に置換する
        $replacedTemplate = str_replace($tag, "", $replacedTemplate);
    }
}

//置換後のtemplateを出力
echo $replacedTemplate;

