<?php
    define('MYSQL_SERVER', 'mysql:host=db;dbname=dbLocation;charset=utf8');
    define('SQL_USER', 'root');
    define('SQL_PASS', 'f4q2DG2obVd3I');

    class PDOFactory {
    // Dans le cas où la base de données serait en MySQL (est utilisé ici).
        public static function getMySQLConnection() {
            $db = new PDO(MYSQL_SERVER, SQL_USER, SQL_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        }
    };
?>