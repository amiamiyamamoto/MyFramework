<?php
require_once '../vendor/BaseController.php';
require_once '../vendor/route.php';

//../controller/内のcontrollerファイルを読み込む
foreach (glob("../controller/*Controller.php") as $fileName) {
    require_once $fileName;
}

//uriを取得
$requestUri = $_SERVER["REQUEST_URI"];
//パラメータを除去
$requestUri = strtok($requestUri, '?');

//Routeインスタンスを生成
$route = new Route();

//ルーティング先の決定
include '../route/route.php';
$controllerName = $route->controllerName;
$controller = new $controllerName();

//controllerの呼び出し
$controller->action();

