<?php

namespace Src\Modules\Main\Models;

use Src\Modules\Entity\Models\EntityModel;

class ModuleModel extends EntityModel
{
    protected $table = 'modules';

    protected $fields = array(
        'name',
        'state',
    );

    public function getModulesForRouting()
    {
        $modules = $this->select(
            $this->table,
            array(),
            array('name', 'state')
        );

        $res = array();
        foreach ($modules as $module) {
            $res[$module['name']] = $module['state'];
        }

        return $res;
    }

    public function getModules()
    {
        return $this->getAllRecords('modules');
    }

    public function getModuleIds() {
        return $this->selectColumns('modules', array('id', 'state'));
    }

    public function setModuleStateMultiple($modules)
    {
        foreach ($modules as $id => $state) {
            $this->setModuleState($id, $state);
        }
    }

    public function setModuleState($id, $state)
    {
        $themesQuestionsQuery = self::getDb()->prepare("UPDATE modules
                                                    SET state = :state
                                                    WHERE id=:id");

        $state = empty($state) ? 0 : 1;
        $themesQuestionsQuery->bindValue(':id', $id);
        $themesQuestionsQuery->bindValue(':state', $state);
        $themesQuestionsQuery->execute();
    }
}