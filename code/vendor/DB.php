<?php
//シングルトンのデータベースクラス作成

class DB
{

    //自分自身を格納するプロパティ
    private static $db;
    //pdoを格納するプロパティ
    private static $pdo;

    //シングルトンを取得するメソッド
    public function getDbInstance() {
        if (!isset(self::$db)) {
            self::$db = new DB();
        }
        return self::$db;
    }

    private function __construct() {}

    //PDOインスタンスを取得するメソッド
    private function getPdo() {
        self::$pdo = null;
        if (!isset(self::$pdo)) {
            $userName = self::getParameterFromEnv('DB_USERNAME'); 
            $password = self::getParameterFromEnv('DB_PASSWORD');
            $dbName   = self::getParameterFromEnv('DB_DATABASE');

            self::$pdo = new PDO('mysql:dbname=myFramework;host=mysql;port=3306', 'root', 'password');
        }
        return self::$pdo;
    }

    //insertのメソッド
    public function insert($query) {
        $pdo = self::getPdo();
        $pdo->prepare($query)->execute();
    }
    //Transactionのメソッド
    public function transaction($query) {
        try {
            $pdo = self::getPdo();
            echo 'getPdoした';
            $pdo->beginTransaction();
            echo 'トランザクション開始した';
            $query();
            $this->insert("insert into users (name, age) values ('メソッド内でインサート', 22)");
            echo 'クエリ実行';
            $pdo->commit();
            echo 'commitした';
            return true;
        } catch (Exception $e) {
            $pdo->rollback();
            echo 'ROLLBACKしたよ';
            return false;
        }
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

