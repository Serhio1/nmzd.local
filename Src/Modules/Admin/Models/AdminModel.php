<?php

namespace Src\Modules\Admin\Models;

use App\Core\Model;

class AdminModel extends Model
{
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