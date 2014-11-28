<?php

namespace App\Core;

use \PDO;

class Model
{
    protected static $db;

    public static function getDb()
    {
        if (!isset(self::$db)) {
            static::$db = new static;
        }
        static::initDbConnection();

        return self::$db;
    }

    private static function initDbConnection()
    {
        try {
            $db = new PDO('pgsql:host='.Container::get('params')->dbHost
                    .';dbname='.Container::get('params')->dbName, 
                    Container::get('params')->dbUser, 
                    Container::get('params')->dbPass
                );
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                static::$db = $db;
                
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        return;
    }

    protected function getAllRecords($table)
    {
        $table = str_replace(" ","",$table);
        $query = self::getDb()->prepare("SELECT *
                                     FROM ".$table);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function selectIn($table, $coloumn, $array)
    {
        $qMarks = str_repeat('?,', count($array)-1).'?';

        $selectQuery = self::getDb()->prepare("SELECT * FROM $table WHERE $coloumn IN ($qMarks)");
        $selectQuery->execute($array);

        return $selectQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function selectColumns($table, $coloumns)
    {
        $columnsStr = implode(',', $coloumns);
        $selectQuery = self::getDb()->prepare("SELECT $columnsStr FROM $table");
        $selectQuery->execute();

        return $selectQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function insert($table, $values)
    {
        $colsStr = implode(', ', array_keys($values));
        $valsStr = ':' . implode(', :', array_keys($values));
        $insertQuery = self::getDb()->prepare("INSERT INTO $table ($colsStr)
                                               VALUES ($valsStr)");
        foreach ($values as $key => $val) {
            if (is_array($val)) {
                $insertQuery->bindValue(':' . $key, '{'.implode(',', $val).'}');
            } else {
                $insertQuery->bindValue(':' . $key, $val);
            }
        }
        $insertQuery->execute();
    }

    protected function select($table, $values, $columns = array(), $distinct = false)
    {
        if (!empty($columns)) {
            $colStr = implode(', ', $columns);
        } else {
            $colStr = '*';
        }

        $valsStr = '';
        foreach ($values as $col => $value) {
            if (!empty($valsStr)) {
                $valsStr .= ' AND ';
            }
            if (!empty($value)) {
                $valsStr .= $col . ' = :' . $col;
            }
        }

        $query = "SELECT ";
        $query .= ($distinct) ? 'DISTINCT ' : '';
        $query .= "$colStr FROM $table ";
        $query .= (!empty($valsStr)) ? "WHERE $valsStr" : '';


        $selectQuery = self::getDb()->prepare($query);

        foreach ($values as $col => $value) {
            $selectQuery->bindValue(':' . $col, $value);
        }

        $selectQuery->execute();

        return $selectQuery->fetchAll(PDO::FETCH_ASSOC);
    }
}
