<?php
require_once '../vendor/BaseController.php';
require_once '../vendor/DbConnectController.php';
require_once '../vendor/route.php';
require_once '../vendor/Database.php';

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
$controllerName = $route->controllerName;
$controller = new $controllerName();

//Databaseシングルトンの呼び出し、トランザクションを開始
//$db = Database::getPdo();
//$db->beginTransaction();

//controllerの呼び出し
$controller->action();

//commitもしくはROLLBACK
//$db->commit();
//$db->rollBack();

//ステータスコードを送る（controllerで指定がない場合は200）
http_response_code($controller->getStatusCode());
//描画する(指定がない場合は空文字を描画)
echo $controller->getHtml();

//phpinfo();
//$db = new PDO('mysql:dbname=myFramework;host=mysql;port=3306', "root", "password");


//$db = Database::getPdo();

//$db->prepare("insert into users (name,age) values ('oba', 60)")->execute();

