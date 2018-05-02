<?php

abstract class DbConnectController extends BaseController {

    //PDOを格納するプロパティ
    protected $pdo;

    //$pdoのメソッドを扱うためのメソッド
    abstract protected function dbAction();

    //dbActionの前後にTransactionの処理を入れる
    public function action() {

        try {
            if (! $this->pdo->beginTransaction()) throw new Exception();
            $this->dbAction();
            $this->pdo->commit();
            echo "どうしたらキャッチにいくの";
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e;
        }
    }

    protected function query($query) {
        if (! $this->pdo->prepare($query)->execute()){
            throw new Exception();
        }
    }

    function __construct() {
        $dbName   = $this->getParameterFromEnv('DB_DATABASE');
        $userName = $this->getParameterFromEnv('DB_USERNAME'); 
        $password = $this->getParameterFromEnv('DB_PASSWORD');

        $this->pdo = new PDO('mysql:dbname='.$dbName.';host=mysql;port=3306', $userName, $password);
    }

    private function getParameterFromEnv($parameter) {
        //.envファイルを取得
        $env = file_get_contents('../.env');
        //正規表現
        $regex = '/'.$parameter.'=(\w*)\n/';
        //envから取りだす
        preg_match_all($regex, $env, $matches);
        return $matches[1][0];
    }

}
