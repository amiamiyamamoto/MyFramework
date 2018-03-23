<?php
//uriを取得
$requestUri = $_SERVER["REQUEST_URI"];
//パラメータを除去
$requestUri = strtok($requestUri, '?');

include '../route/route.php';

