<?php
//phpinfo();
require_once '../vendor/BaseController.php';
require_once '../vendor/DbConnectController.php';
require_once '../vendor/route.php';
require_once '../vendor/DB.php';
require_once '../vendor/ValidationTrait.php';

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
require '../route/route.php';
$controllerName = $route->getControllerName();
$controller = new $controllerName();

//controllerの呼び出し
$controller->action();

//ステータスコードを送る（controllerで指定がない場合は200）
http_response_code($controller->getStatusCode());
//描画する(指定がない場合は空文字を描画)
echo $controller->getHtml();

