<?php
  define('MYSQL_SERVER', 'mysql:host=db;dbname=boutique_casques_vr;charset=utf8');
  define('SQL_USER', 'root');
  define('SQL_PASS', 'f4q2DG2obVd3I');

    class PDOFactory {
        public static function getMySQLConnection() {
            $db = new PDO(MYSQL_SERVER, SQL_USER, SQL_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        }
    };
?>