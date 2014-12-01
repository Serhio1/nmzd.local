<?php

namespace Src\Modules\Entity\Models;

use App\Core\Model;
use App\Core\Container;
use App\Core\Router;

class EntityModel extends Model
{

    public function getFields()
    {
        return $this->fields;
    }

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

    public function getEntityList()
    {
        $menuData = $this->select(
            $this->table,
            array()
        );

        return $menuData;
    }

    public function getParentEntityList($parent_id)
    {
        $menuData = $this->select(
            $this->table,
            array($this->parent . '_id' => $parent_id)
        );

        return $menuData;
    }

    public function selectEntity($selectParams, $columns = array(), $order = array('columns' => 'id', 'type' => 'DESC'))
    {
        if (!empty($selectParams)) {
            $menuItems = $this->select(
                $this->table,
                $selectParams,
                $columns,
                $order
            );

            return $menuItems;
        }
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

    public function updateEntity($values, $selectParams)
    {
        $this->update($this->table, $values, $selectParams);
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
