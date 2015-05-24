<?php

namespace Src\Modules\Nmkd\Models;

use App\Core\Model;
use App\Core\Container;
use \PDO;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Router;

class NmkdModel extends Model
{
    private $tqForTypes = array();
    
    public function PdfMethodicalRecommendations(Request $request)
    {
        $discipline = Container::get('Nmkd/DisciplineModel')->selectById($request->query->get('id'));
        return array(
            'disc_name' => $discipline['title'],
            'year' => date("Y"),
        );
    }
    
    public function PdfWorkPlan(Request $request)
    {
        $discipline = Container::get('Nmkd/DisciplineModel')->selectById($request->query->get('id'));
        $program = $this->select(
            'themes_questions', 
            array('id_discipline' => $request->query->get('id'))
        );
        $typesSelection = Container::get('Nmkd/TypesModel')->getEntityList();
        $types = array();
        foreach ($typesSelection as $type) {
           $types[$type['key']] = $type['id']; 
        }
        return array(
            'disc_name' => $discipline['title'],
            'year' => date("Y"),
            'program' => $program,
            'types' => $types,
            'base_url' => Container::get('params')->getBasePath(),
            'img_emblem' => Router::buildUrl('/Src/Modules/Nmkd/Views/img/emblem.png'),
            'img_header' => Router::buildUrl('/Src/Modules/Nmkd/Views/img/header.png'),
            'img_sign' => Router::buildUrl('/Src/Modules/Nmkd/Views/img/sign.png'),
        );
    }
    
    public function PdfTrainingPlan(Request $request)
    {
        $discipline = Container::get('Nmkd/DisciplineModel')->selectById($request->query->get('id'));
        return array(
            'disc_name' => $discipline['title'],
            'year' => date("Y"),
        );
    }
    
    public function PdfTest(Request $request)
    {
        $discipline = Container::get('Nmkd/DisciplineModel')->selectById($request->query->get('id'));
        $program = $this->select(
                'themes_questions', 
                array('id_discipline' => $request->query->get('id'))
        );
        
        return array(
            'disc_name' => $discipline['title'],
            'year' => date("Y"),
            'program' => $program
        );
    }
    
    /**
     * Creates new Nmkd.
     * 
     * @param type $questions - array('question1', 'question2' ...).
     * @param type $disciplineId - integer, id of current discipline.
     * @param type $typesQuestions - array(question_key => type_id). question_key - key from $questions element.
     * @param type $hierarchy - array(question_key => hierarchy_position). hierarchy_position - 2 value of hierarchy PFBC element
     */
    public function createEntity($questions, $disciplineId, $typesQuestions, $hierarchy)
    {
        $idTypes = Container::get('Nmkd/TypesModel')
        ->selectEntity(array(), array('id', 'key'), array('columns' => 'id', 'type' => 'ASC'));
        
        $query = self::getDb()->prepare(
                            "INSERT INTO 
                                 themes_questions
                                 (name, id_discipline, id_parent, types_id, num_tq)
                             VALUES 
                                 (:name, :id_disc, :id_parent, :types_id, :num_tq) 
                             RETURNING id_tq");
        
        $TQIds = array();
        $TQNames = array();
        foreach ($questions as $key=>$name) {
            $typesArr = array();
            $query->bindValue(':name', $name);
            $query->bindValue(':id_disc', $disciplineId);
            $query->bindValue(':num_tq', $key);
            if ($hierarchy[$key] == 0) {
                $query->bindValue(':id_parent', -1);
                $query->bindValue(':types_id', '{}');
                $query->execute();
                $MQId = $query->fetchAll(PDO::FETCH_ASSOC);
                continue;
            }
            elseif ($hierarchy[$key] == 1) {
                $query->bindValue(':id_parent', $MQId[0]['id_tq']);
                $query->bindValue(':types_id', '{}');
                
                $query->execute();
                $TQNames[] = $name;
                $TQIds[] = $query->fetchAll(PDO::FETCH_ASSOC);
                continue;
            }
            else {
                $typesArr = array();
                if (isset($typesQuestions[$key])) {
                    $typesArr = $typesQuestions[$key];
                }
                $query->bindValue(':id_parent', $TQIds[count($TQIds)-1][0]['id_tq']);
                $query->bindValue(':types_id', '{'.implode(',', $typesArr).'}');
                
                $query->execute();
                $TQIds[count($TQIds)-1][0]['q_ids'][] = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        foreach ($idTypes as $typeRow) {
            
            $typesQuery = self::getDb()->prepare(
                            "INSERT INTO " . $typeRow['key'] . "(id_disc, semester, theme, questions, id_theme)
                             VALUES (:id_disc, :semester, :theme, :questions, :id_theme)");
            
            foreach ($TQNames as $key => $themeName) {
                $questionsArr = array();
                foreach ($TQIds[$key][0]['q_ids'] as $qRow => $qVal) {
                    $questionsArr[] = $qVal[0]['id_tq'];
                }
                $typesQuery->bindValue(':id_disc', $disciplineId);
                $typesQuery->bindValue(':semester', 1);
                $typesQuery->bindValue(':theme', $themeName);
                $typesQuery->bindValue(':questions', '{'.implode(',', $questionsArr).'}');
                $typesQuery->bindValue(':id_theme', $TQIds[$key][0]['id_tq']);
                $typesQuery->execute();
            }
        }
    }
    
    public function selectEntity($disciplineId)
    {
        return $this->select('themes_questions', array('id_discipline'=>$disciplineId));
    }
    
    public function selectQuestionHierarchy($disciplineId)
    {
        $mQuestions = $this->select('themes_questions', 
                array('id_discipline'=>$disciplineId), 
                array('id_tq', 'id_parent', 'num_tq'), 
                array('columns'=>'num_tq', 'type'=>'ASC'));
        $res = array();
        $mId = 0;
        foreach ($mQuestions as $row => $question) {
            if ($question['id_parent'] == '-1') {
                $res[$question['num_tq']] = 0;
                $mId = $question['id_tq'];
            } elseif ($question['id_parent'] == $mId) {
                $res[$question['num_tq']] = 1;
            } else {
                $res[$question['num_tq']] = 2;
            }
        }
   
        return $res;
    }
    
    public function selectTypes($disciplineId)
    {
        $query = static::getDb()->prepare(
                            "SELECT 
                                types_id, 
                                num_tq 
                             FROM 
                                 themes_questions
                             WHERE 
                                 id_discipline = :id_disc 
                             AND 
                                 types_id != '{}'
                             ORDER BY num_tq ASC");

        $query->bindValue(':id_disc', $disciplineId);
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res as $row => $data) {
            $res[$row]['types_id'] = $this->pgArrayParse($data['types_id']);
        }
   
        return $res;
    }

    /**
     * Deletes current questions for discipline and set new questions.
     * 
     * @param type $questions
     * @param type $disciplineId
     * @param type $typesQuestions
     * @param type $hierarchy
     */
    public function updateEntity($questions, $disciplineId, $typesQuestions, $hierarchy)
    {
        self::getDB()->beginTransaction();
        $types = Container::get('Nmkd/TypesModel')
        ->selectEntity(array(), array('key'), array());
        
        $deleteTQQuery = self::getDb()->prepare("DELETE FROM themes_questions WHERE id_discipline = :id_disc");
        $deleteTQQuery->bindValue(':id_disc', $disciplineId);
        $deleteTQQuery->execute();
        
        foreach ($types as $type) {
            $deleteTypeQuery = self::getDb()->prepare("DELETE FROM $type[key] WHERE id_disc = :id_disc");
            $deleteTypeQuery->bindValue(':id_disc', $disciplineId);
            $deleteTypeQuery->execute();
        }
        $this->createEntity($questions, $disciplineId, $typesQuestions, $hierarchy);
        self::getDB()->commit();
    }



    public function getDisciplines()
    {
        $discQuery = self::getDb()->prepare("SELECT id,name FROM discipline");
        $discQuery->execute();
        $res = $discQuery->fetchAll(PDO::FETCH_ASSOC);
        
        return $res;
    }

    protected function updateThemesQuestions($lastLoadedQuestions, $questions, $hierarchy)
    {
        $themesQuestionsQuery = self::getDb()->prepare("UPDATE themes_questions
                                                    SET id_parent = :id_parent,
                                                        num_tq = :num_tq
                                                    WHERE id_tq=:id");
        self::getDb()->beginTransaction();
            $hierarchyVals = array_values($hierarchy);
            $hierarchyKeys = array_keys($hierarchy);
            for ($i=0; $i<count($questions); $i++) {
                if ($hierarchyVals[$i]=='module') {
                    $id_parent = -1;
                    $id = array_search($questions[$hierarchyKeys[$i]], $lastLoadedQuestions);
                }
                if ($hierarchyVals[$i]=='theme') {
                    for ($j=$i; $j>=0; $j--) {
                        if ($hierarchyVals[$j]=='module') {
                            $id_parent = array_search($questions[$hierarchyKeys[$j]], $lastLoadedQuestions);
                            $id = array_search($questions[$hierarchyKeys[$i]], $lastLoadedQuestions);
                            break;
                        }
                    }
                }
                if ($hierarchyVals[$i]=='question') {
                    for ($j=$i; $j>=0; $j--) {
                        if ($hierarchyVals[$j]=='theme') {
                            $id_parent = array_search($questions[$hierarchyKeys[$j]], $lastLoadedQuestions);
                            $id = array_search($questions[$hierarchyKeys[$i]], $lastLoadedQuestions);
                            $this->tqForTypes[$id_parent][$hierarchyKeys[$i]] = $id;
                            break;
                        }
                    }
                }
                $themesQuestionsQuery->bindValue(':id_parent', $id_parent);
                $themesQuestionsQuery->bindValue(':id', $id);
                $themesQuestionsQuery->bindValue(':num_tq', $i);
                $themesQuestionsQuery->execute();
            }
        self::getDb()->commit();
    }

    protected function setTypes($lastLoadedQuestions, $questions, $hierarchy, $idTypes, $disciplineId, $semester, $typesQuestions)
    {
        $tqTypes = array();
        foreach ($idTypes as $id=>$type) {
            $questionsForTypeStr = 'questions_for_'.$type;

            $insertTypeQuery = self::getDb()->prepare("INSERT INTO $type(theme, id_theme, semester, id_disc, $questionsForTypeStr)
                                                   VALUES (:theme, :id_theme, :semester, :id_disc, :questions_for_type)");




            $questionTypes = array();
            foreach ($this->tqForTypes as $theme_id=>$questionsForTheme) {
                $questionsForType = array();
                foreach ($questionsForTheme as $questionNum=>$questionId) {
                    if (isset($typesQuestions[$questionNum])) {
                        if (isset($typesQuestions[$questionNum][$type])) {
                            $questionsForType[] = $questionId;
                        }
                        if ((!isset($questionTypes[$questionId]) || $questionTypes[$questionId] != array_search($type, $idTypes)) && in_array($type, $idTypes)) {
                            $questionTypes[$questionId][] = array_search($type, $idTypes);
                        }
                    }

                }
                if (!empty($questionsForType)) {
                    $insertTypeQuery->bindValue(':theme', $lastLoadedQuestions[$theme_id]);
                    $insertTypeQuery->bindValue(':id_theme', $theme_id);
                    $insertTypeQuery->bindValue(':semester', $semester);
                    $insertTypeQuery->bindValue(':id_disc', $disciplineId);
                    $insertTypeQuery->bindValue(':questions_for_type', '{'.implode(',',$questionsForType).'}');
                    $insertTypeQuery->execute();
                }
                /*if (!empty($questionTypes)) {
                    foreach ($questionTypes as $idTq => $tId) {
                        $addTypeToQuestionQuery->bindValue(':types_id', '{'.implode(',',$tId).'}');
                        $addTypeToQuestionQuery->bindValue(':id_tq', $idTq);
                        $addTypeToQuestionQuery->execute();
                    }

                }*/
            }
        }

        $this->setTQTypes($lastLoadedQuestions, $questions, $typesQuestions, $idTypes);
    }

    public function setTQTypes($lastLoadedQuestions, $questions, $typesQuestions, $idTypes)
    {
        $addTypeToQuestionQuery = self::getDb()->prepare("UPDATE themes_questions
                                                     SET types_id = :types_id
                                                     WHERE id_tq = :id_tq");

        foreach ($lastLoadedQuestions as $id => $questionName) {
            $qTypes = array();
            $questionNum = array_search($questionName, $questions);
            if (!empty($typesQuestions[$questionNum])) {
                foreach ($typesQuestions[$questionNum] as $typeName => $val) {
                    $qTypes[] = array_search($typeName, $idTypes);
                }
                $addTypeToQuestionQuery->bindValue(':types_id', '{' . implode(',', $qTypes) . '}');
                $addTypeToQuestionQuery->bindValue(':id_tq', $id);
                $addTypeToQuestionQuery->execute();
            }
        }

    }
    
//main function
    public function setAllQuestions($questions)
    {
        $this->questions = $questions;
        $storage = Container::get('session_storage');
        $themes = $storage->get('themes');
        $modules = $storage->get('modules');
        $tqQuery = self::$db->prepare("INSERT INTO themes_questions(name, id_discipline, types_id, num_tq)
                                      VALUES (:name, :id_disc, :types_id, :num_tq) ");
        foreach($questions as $qKey => $question){
            $typesId[$qKey] = $this->getQuestionTypes($qKey);
        }
        $num_tq = 0;
        self::$db->beginTransaction();
        
        $questions = array_diff($questions, array_intersect_key($questions, array_flip($modules))); //cut modules
        
        
            foreach($questions as $qKey => $question){
                if (array_search($qKey, $themes)) {
                    $num_tq = 0;
                }
                $tqQuery->bindValue(':name', $question);
                $tqQuery->bindValue(':id_disc', 1);
                $tqQuery->bindValue(':num_tq', $num_tq++);
                $tqQuery->bindValue(':types_id', '{'.implode(',', $typesId[$qKey]).'}');
                $tqQuery->execute();
            }
        self::$db->commit();

        $dump = $this->getLastLoadedQuestions();

        $this->setModules($dump, 1);

        foreach ($this->getIdTypes() as $id => $type) {
            $this->setQuestionsTypes($type, $id);
            $this->setQuestionsForType($type, $dump);
            $this->setIdParent($type, $dump);
        }
    }
  
//returns array of types id => types name from session_storage
    private function getIdTypes()
    {
        $storage = Container::get('session_storage');
        $types = $storage->get('types');
        $typesRows = $this->selectIn('types', 'name', array_keys($types));

        $typesIdName = array();
        foreach ($typesRows as $row) {
            $typesIdName[$row['id']] = $row['name'];
        }

        return $typesIdName;
    }

//return array [id] => name from 'types' table 
    protected function getTypes()
    {
        $typeQuery = self::$db->prepare('SELECT * FROM types');
        self::$db->beginTransaction();
            $typeQuery->execute();
        self::$db->commit();
        $typesDump = $typeQuery->fetchAll(PDO::FETCH_ASSOC);

        $res = array();
        end($typesDump);
        for ($i=0; $i<=key($typesDump); $i++) {
            $res[$typesDump[$i]['id']] = $typesDump[$i]['name'];
        }

        return $res;
    }

//returns array of types id from database for question
    protected function getQuestionTypes($qKey)
    {
        $storage = Container::get('session_storage');
        $types = $storage->get('types');
        $dbTypes = $this->getIdTypes();
        $idArr = array();
        foreach ($types as $name => $data) {
            foreach ($data as $qNum) {
                if ($qKey == $qNum) {
                    $idArr[] = array_search($name, $dbTypes);
                }
            }
        }

        return $idArr;
    }

//inserts id_disc,semester,theme into lection/practical/seminary/... 
    private function setQuestionsTypes($currentType)
    {
        $insertTypeQuery = self::$db->prepare("INSERT INTO $currentType(theme, semester, id_disc)
                                               VALUES (:theme, :semester, :id_disc)");

        foreach ($this->getTypeThemes($currentType) as $theme) {
            
            if (!$this->themeExists($currentType, $theme)) {
                //insert
                self::$db->beginTransaction();
                    $insertTypeQuery->bindValue(':theme', $theme);
                    $insertTypeQuery->bindValue(':semester', 1);
                    $insertTypeQuery->bindValue(':id_disc', 1);         //todo: id_disc
                    $insertTypeQuery->execute();
                self::$db->commit();
            }
        }
        
    }

//if theme exists in current database return true
    private function themeExists($currentType, $theme)
    {
        $selectTypeQuery = self::$db->prepare("SELECT COUNT(*) FROM $currentType
                                               WHERE theme=:theme");

        self::$db->beginTransaction();
            $selectTypeQuery->bindValue(':theme', $theme);
            $selectTypeQuery->execute();
        self::$db->commit();

        if (count($selectTypeQuery->fetchAll(PDO::FETCH_ASSOC)) > 0) {
            return false;
        } else {
            return true;
        }
    }

//returns array of themes for current type
    private function getTypeThemes($currentType)
    {
        $res = array();
        $storage = Container::get('session_storage');
        $typeTheme = $storage->get($currentType.'_theme');
        
        $themesKeys = array_unique(array_values($typeTheme));
        $storageThemes = $storage->get('themes');
        $questions = $storage->get('questions');
        foreach ($themesKeys as $key) {
            $res[] = $questions[$storageThemes[$key]];
        }

        return $res;
    }

//updates lection / practical /...  sets questions_for_lection / questions_for.... 
    private function setQuestionsForType($currentType, $dump)
    {
        $storage = Container::get('session_storage');
        $typeTheme = $storage->get($currentType.'_theme');
        $typeTheme = $this->getTypeThemeArray($currentType);
        $q_f_type = 'questions_for_'.$currentType;
        $updateTypeQuery = self::$db->prepare("UPDATE $currentType
                                              SET $q_f_type = :questionsArr
                                              WHERE theme=:theme");
                                            
        foreach ($typeTheme as $question=>$theme) {
            $idQuestionToTheme[array_search($question, $dump)] = $theme;
        }

        foreach ($typeTheme as $question=>$theme) {
            $keys = array_keys($idQuestionToTheme, $theme);
            self::$db->beginTransaction();
                $updateTypeQuery->bindValue(':theme', $theme);
                $updateTypeQuery->bindValue(':questionsArr', '{'.implode(',', $keys).'}');
                $updateTypeQuery->execute();
            self::$db->commit();
        }
        
    }

//updates themes_questions, sets id_parent
    private function setIdParent($currentType, $dump)
    {
        $storage = Container::get('session_storage');
        $typeTheme = $storage->get($currentType.'_theme');
        $typeTheme = $this->getTypeThemeArray($currentType);

        $updateThemesQuestoinsQuery = self::$db->prepare("UPDATE themes_questions
                                                          SET id_parent = :id_parent
                                                          WHERE name=:name");

        foreach ($typeTheme as $question=>$theme) {
            if ($question != $theme) {
                self::$db->beginTransaction();
                    $updateThemesQuestoinsQuery->bindValue(':id_parent', array_search($theme, $dump));
                    $updateThemesQuestoinsQuery->bindValue(':name', $question);
                    $updateThemesQuestoinsQuery->execute();
                self::$db->commit();
            }
        }
        
    }

//inserts modules data into modules table
    private function setModules($dump, $disciplineId)
    {
        $storage = Container::get('session_storage');
        $modulesNums = $storage->get('modules');
        $questions = $storage->get('questions');
        $themesModules = $storage->get('themes_modules');

        foreach ($themesModules as $theme=>$module) {
            $themesId[$module][] = array_search($questions[$theme] ,$dump);
            $modules[$module] = $questions[$module];
        }

        $moduleQuery = self::$db->prepare("INSERT INTO modules(id_disc, module, themes)
                                           VALUES(:id_disc, :module, :themes)");

        self::$db->beginTransaction();
            foreach ($modules as $key=>$module) {
                $moduleQuery->bindValue(':id_disc', $disciplineId);
                $moduleQuery->bindValue(':module', $module);
                if (count($themesId[$key])>1) {
                    $moduleQuery->bindValue(':themes', '{'.implode(',',$themesId[$key]).'}');
                } else {
                    $moduleQuery->bindValue(':themes', '{'.implode(',',$themesId[$key]).'}');
                }
                $moduleQuery->execute();
            }

            
            
        self::$db->commit();
    }

//return array(['question_name'] => theme_name) from storage
    protected function getTypeThemeArray($currentType)
    {
        $storage = Container::get('session_storage');
        $typeTheme = $storage->get($currentType.'_theme');
        $themes = $storage->get('themes');
        $questions = $storage->get('questions');
        $res = array();
        foreach ($typeTheme as $qNum => $themeNum) {
            $res[$questions[$qNum]] = $questions[$themes[$themeNum]];
        }

        return $res;
    }

    
//return dump of last loaded questions in themes_questions: array([id]=>name)
    private function getLastLoadedQuestions($questions)
    {
        //$questions = Container::get('session_storage')->get('questions');
        $storage = Container::get('session_storage');
        $lastTqQuery = self::$db->prepare("SELECT id_tq, name
                                         FROM themes_questions
                                         ORDER BY id_tq DESC
                                         LIMIT :qCount");
        self::$db->beginTransaction();
            $lastTqQuery->bindValue(':qCount',count($questions));
            $lastTqQuery->execute();
        self::$db->commit();

        $res = $lastTqQuery->fetchAll(PDO::FETCH_NUM);
        foreach ($res as $key=>$val) {
            $questionIdNames[$res[$key][0]] = $res[$key][1];
        }

        return $questionIdNames;
    }

//save current step of nmkd generation in 'session' table
    public function saveSession($step, $idDiscipline)
    {
        $sessionData = Container::get('session_storage')->getAll();
        $sessionData['step'] = $step;

        if ($this->sessionExists($idDiscipline)) {
            $sessionQuery = self::$db->prepare("UPDATE sessions SET
                                                session_data = :session_data
                                                WHERE id_disc = :id_disc ");
        } else {
            $sessionQuery = self::$db->prepare("INSERT INTO sessions(session_data, id_disc)
                                      VALUES (:session_data, :id_disc) ");
        }

        self::$db->beginTransaction();
            $sessionQuery->bindValue(':session_data', serialize($sessionData));
            $sessionQuery->bindValue(':id_disc', $idDiscipline);
            $sessionQuery->execute();
        self::$db->commit();

        print_r($sessionData);
    }
    
    public function sessionExists($idDiscipline) 
    {
        $sessionQuery = self::$db->prepare("SELECT id_disc FROM sessions
                                            WHERE id_disc = :id_disc");
        $sessionQuery->bindValue(':id_disc', $idDiscipline);
        $sessionQuery->execute();
        $res = $sessionQuery->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($res)) {
            return true;
        }
        return false;
    }

    public function getSession($idDiscipline)
    {
        $sessionQuery = self::$db->prepare("SELECT session_data FROM sessions
                                            WHERE id_disc = :id_disc");
        self::$db->beginTransaction();
            $sessionQuery->bindValue(':id_disc', $idDiscipline);
            $sessionQuery->execute();
        self::$db->commit();

        $res = $sessionQuery->fetchAll(PDO::FETCH_ASSOC);
    
        return unserialize($res['0']['session_data']);
    }

    public function getSessionList()
    {
        $sessionListQuery = self::$db->prepare("SELECT * FROM sessions");//WHERE user_id = :user_id
        $disciplineQuery = self::$db->prepare("SELECT name FROM discipline WHERE id=:id");
            
        self::$db->beginTransaction();
            $sessionListQuery->execute();
        self::$db->commit();
        $res = $sessionListQuery->fetchAll(PDO::FETCH_ASSOC);

        end($res);
        self::$db->beginTransaction();
            for ($i=0; $i<=key($res); $i++) {
                $disciplineQuery->bindParam(':id', $res[$i]['id_disc']);
                $disciplineQuery->execute();
            }
        self::$db->commit();    
        $names = $disciplineQuery->fetchAll(PDO::FETCH_ASSOC);
        
        for ($i=0; $i<=key($res); $i++) {
            $res[$i]['name'] = $names[$i]['name'];
        }
    
        return $res;
    }
}
