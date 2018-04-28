<?php
//シングルトンのデータベースクラス作成

class Database
{

    //自分自身を格納するプロパティ
    private static $db;
    //pdoを格納するプロパティ
    private static $pdo;
    //エラーを格納するプロパティ
    private $commitFlag = true;

    private function __construct() {
        $dbName   = $this->getParameterFromEnv('DB_DATABASE');
        $userName = $this->getParameterFromEnv('DB_USERNAME'); 
        $password = $this->getParameterFromEnv('DB_PASSWORD');

        self::$pdo = new PDO('mysql:dbname='.$dbName.';host=mysql;port=3306', $userName, $password);
        self::$db = new Database();
    }

    //PDOでデータベースに接続するメソッド
    public static function getPdo() {
        if (!isset(self::$db)) {
            new self();
        }
        return self::$db;
    }

    //insertのメソッド
    public function insert($query) {
        if (!isset(self::$pdo)) {
            return;
        }
        $this->commitFlag = self::$pdo->prepare($query)->execute();

    }

    //エラーが起きたかどうかを返す
    public function getCommitFlag() {
        return $this->commitFlag;
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

