<?php

namespace App\Core;

use \PDO;

class Model
{
    protected static $db;

    public static function getDb()
    {
        if (!isset(static::$db)) {
            static::$db = new static;
            static::initDbConnection();
        }

        return static::$db;
    }

    private static function initDbConnection()
    {
        try {
            
            $db = new PDO(
                    'pgsql:host='.Container::get('params')->getDbData('host')
                    .';dbname='.Container::get('params')->getDbData('db'), 
                    Container::get('params')->getDbData('user'), 
                    Container::get('params')->getDbData('pass')
                );
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                static::$db = $db;
                
        } catch(PDOException $e) {
            echo $e->getMessage('Can\'t connect to database.');
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

    protected function selectIn($table, $coloumn, $array, $columns=array())
    {
        $qMarks = str_repeat('?,', count($array)-1).'?';
        if (!empty($columns)) {
            $columnsStr = implode(',', $columns);
        } else {
            $columnsStr = '*';
        }

        $selectQuery = self::getDb()->prepare("SELECT $columnsStr FROM $table WHERE $coloumn IN ($qMarks)");
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
                                               VALUES ($valsStr)
                                               RETURNING id");
        foreach ($values as $key => $val) {
            if (is_array($val)) {
                $insertQuery->bindValue(':' . $key, '{'.implode(',', $val).'}');
            } else {
                $insertQuery->bindValue(':' . $key, $val);
            }
        }
        $insertQuery->execute();

        return $insertQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function select($table, $values, $columns = array(), $order = array(), $distinct = false, $paged=array())
    {
        if (!empty($columns)) {
            $colStr = implode(', ', $columns);
        } else {
            $colStr = '*';
        }

        $valsStr = $this->condition($values);

        $query = "SELECT ";
        $query .= ($distinct) ? 'DISTINCT ' : '';
        $query .= "$colStr FROM $table ";
        $query .= (!empty($valsStr)) ? "WHERE $valsStr " : '';
        $query .= (!empty($order)) ? "ORDER BY $order[columns] $order[type] " : '';
        if (!empty($paged)) {
            if (!empty($paged[0])) {
                $query .= "OFFSET $paged[0] ";
            }
            if (!empty($paged[1])) {
                $query .= "LIMIT $paged[1] ";
            }
        }
        
        $selectQuery = self::getDb()->prepare($query);

        foreach ($values as $col => $value) {
            $selectQuery->bindValue(':' . $col, $value);
        }
        $selectQuery->execute();

        return $selectQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectById($id)
    {
        $row = $this->select($this->table, array('id' => $id));
        if (!empty($row['0'])) {
            return $row['0'];
        }
    }

    protected function update($table, $values, $selectParams)
    {
        if (empty($table) || empty($values) || empty ($selectParams)) {
            throw new \Exception('Invalid parameters');
            return;
        }
        $valsStr = '';
        foreach ($values as $col => $value) {
            if (!empty($value)) {
                $valsStr .= $col . ' = :' . $col . ',';
            }
        }
        $valsStr = rtrim($valsStr, ',');

        $selectStr = $this->condition($selectParams);

        $query = "UPDATE $table ";
        $query .= "SET $valsStr ";
        $query .= "WHERE $selectStr";

        $selectQuery = self::getDb()->prepare($query);

        $values = array_merge($values, $selectParams);
        foreach ($values as $col => $value) {
            $selectQuery->bindValue(':' . $col, $value);
        }

        $selectQuery->execute();

        return $selectQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($table, $selectParams)
    {
        $condition = $this->condition($selectParams);
        $deleteQuery = self::getDb()->prepare("DELETE FROM $table
                                         WHERE $condition");
        foreach ($selectParams as $col => $value) {
            $deleteQuery->bindValue(':' . $col, $value);
        }
        $deleteQuery->execute();
    }
    
    public function getCount($table)
    {
        $query = self::getDb()->prepare("SELECT COUNT(*) FROM $table");
        $query->execute();
        return $query->fetchColumn();
    }

    private function condition($selectParams)
    {
        $selectStr = '';
        foreach ($selectParams as $col => $value) {
            if (!empty($selectStr)) {
                $selectStr .= ' AND ';
            }
            if (!empty($value)) {
                $selectStr .= $col . ' = :' . $col;
            }
        }

        return $selectStr;
    }
    
    protected function pgArrayParse($literal)
    {
        if ($literal == '') {
            return;
        }
        preg_match_all('/(?<=^\{|,)(([^,"{]*)|\s*"((?:[^"\\\\]|\\\\(?:.|[0-9]+|x[0-9a-f]+))*)"\s*)(,|(?<!^\{)(?=\}$))/i', $literal, $matches, PREG_SET_ORDER);
        $values = [];
        foreach ($matches as $match) {
            $values[] = $match[3] != '' ? stripcslashes($match[3]) : (strtolower($match[2]) == 'null' ? null : $match[2]);
        }
        return $values;
    }

}
