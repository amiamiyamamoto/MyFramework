<?php
require '../controller/BaseController.php';
require '../controller/ObaController.php';
require '../controller/HasuminController.php';
require '../controller/OtherController.php';

//ルーティング
switch ($requestUri) {
case "/oba":
    $controller = new ObaController();
    break;
case "/hasumin":
    $controller = new HasuminController();
    break;
default:
    $controller = new OtherController();
}

//コントローラの呼び出し
$controller->action();

//前回の残り//
//route('/oba', 'oba');
//route('/hasumin', 'hasumin');

//controllerをincludeする関数
//function route($uri, $controller) {
//    global $requestUri;
//    if ($uri == $requestUri) {
//        include '../controller' . $uri . '.php';
//    }
//}
