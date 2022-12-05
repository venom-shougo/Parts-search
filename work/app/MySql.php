<?php

class Db
{
    public static function searchTables()
    {
        $result = false;
        $sql = "SHOW TABLES";
        try {
            $stmt = Database::connect()->query($sql);
            $result = $stmt->fetchAll();
            return $result;
        } catch(PDOException $e) {
            echo 'DB_E01取得失敗' . $e->getMessage();
            return $result;
        }
    }

    public static function getColumn($column)
    {
        $result = false;

        $sql = "SHOW COLUMNS FROM " . $column['db'];

        try {
            $stmt = Database::connect()->query($sql);
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo 'DB_E01取得失敗' . $e->getMessage();
            return $result;
        }
    }
}
