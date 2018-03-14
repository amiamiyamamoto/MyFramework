<?php

route('/oba', 'oba');
route('/hasumin', 'hasumin');
//controllerをincludeする関数
function route($uri, $controller) {
    global $requestUri;
    if ($uri == $requestUri) {
        include '../controller' . $uri . '.php';
    }
}
