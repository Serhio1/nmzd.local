<?php

namespace Src\Modules\Entity\Models;

use App\Core\Model;
use App\Core\Container;
use App\Core\Router;

class EntityModel extends Model
{

    /**
     * Returns array of fields of current entity.
     * 
     * @return type
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Returns parent if entity has parent. Else returns null.
     * 
     * @return null
     */
    public function getParent()
    {
        if (!empty($this->parent)) {
            return $this->parent;
        } else {
            return Null;
        }
    }

    /**
     * Returns parent_id value for field with id = $id.
     *
     * @param $id
     * @return null
     */
    public function getParentId($id)
    {
        if (!empty($this->parent)) {
            $parentId = $this->select(
                $this->table,
                array('id' => $id),
                array($this->parent . '_id')
            );
            return $parentId;
        } else {
            return Null;
        }
    }

    /**
     * 
     * @return type
     */
    public function getEntityList()
    {
        $menuData = $this->select(
            $this->table,
            array()
        );

        return $menuData;
    }

    /**
     * 
     * @param type $parent_id
     * @return type
     */
    public function getParentEntityList($parent_id)
    {
        $menuData = $this->select(
            $this->table,
            array($this->parent . '_id' => $parent_id)
        );

        return $menuData;
    }

    /**
     * Makes SELECT query to table of this entity.
     * 
     * @param type $selectParams - array('id'=>1, 'title'=>'test') - return all rows, where id==1 and title=='test'
     * @param type $columns - array('id') - return only records in 'id' column
     * @param type $order - array('columns' => 'DESC') - column of order and type of order
     * @return type
     */
    public function selectEntity($selectParams, $columns = array(), $order = array('columns' => 'id', 'type' => 'DESC'))
    {
        //if (!empty($selectParams)) {
        $menuItems = $this->select(
            $this->table,
            $selectParams,
            $columns,
            $order
        );

        return $menuItems;
    }

    /**
     * @param array $values - array(column_name1 => value1,
     *                              column_name2 => value2)
     * @param string $selectParam - column_name, if not empty checks unique value for column
     */
    public function createEntity($values, $selectParam = '')
    {
        if (!empty($selectParam)) {
            $menuItemExist = $this->select($this->table, array($selectParam => $values[$selectParam]));
        }
        if (empty($menuItemExist)) {
            $id = $this->insert($this->table, $values);
        }

        return $id;
    }

    /**
     * Makes UPDATE query to table of entity.
     * 
     * @param type $values
     * @param type $selectParams
     */
    public function updateEntity($values, $selectParams)
    {
        $this->update($this->table, array_filter($values), $selectParams);
    }

    /**
     * Deletes single row from menus table.
     *
     * @param $selectParams - array(column_name1 => value1,
     *                              column_name2 => value2)
     */
    public function deleteEntity($selectParams)
    {
        $this->delete($this->table, $selectParams);
    }

}
