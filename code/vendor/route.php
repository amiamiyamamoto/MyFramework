<?php

class Route
{
    //Controller名を格納する
    public $controllerName = 'OtherController';

    /**
     * ルーティング先のコントローラ名を
     * controllerプロパティに格納する
     * 
     * @param String $uri URI名（頭に/を付ける）
     * @param String $controllerName 呼び出したいcontrollerの名前
     */
     public function routing($uri, $controllerName) {
        global $requestUri;
        if ($uri == $requestUri) {
            $this->controllerName = $controllerName;
        } 
    }
}
