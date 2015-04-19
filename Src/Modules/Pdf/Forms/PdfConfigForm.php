<?php

namespace Src\Modules\Pdf\Forms;

use Src\Modules\Entity\Forms\EntityForm;
use Symfony\Component\HttpFoundation\Request;
use PFBC\Element;
use App\Core\Container;

class PdfConfigForm extends EntityForm
{

    protected $formName = 'pdf_config_form';

    protected $entity = 'Pdf/PdfConfigModel';

    protected function config()
    {
        return array("prevent" => array("bootstrap", "jQuery"));
    }

    protected function defineFields($form, $values = array(), $operation)
    {     
        $request = Request::createFromGlobals();
        if ($operation == 'delete') {
            $form->addElement(new Element\HTML('<legend>Видалити конфігурацію?</legend>'));
            $this->addControls($form, $request);
        } else {
            $form->addElement(new Element\HTML('<legend>Створення нової конфігурації</legend>'));
            $form->addElement(new Element\Textbox('Назва:', 'title', array(
                'required' => 1,
                'value' => empty($values['title']) ? '' : $values['title'],
            )));
            $form->addElement(new Element\Select('Тип сторінок:', 'page_type', array(
                '4A0' => '4A0 (1682 x 2378)',
                '2A0' => '2A0 (1189 x 1682)',
                'A0' => 'A0 (841 x 1189)',
                'A1' => 'A1 (594 x 841)',
                'A2' => 'A2 (420 x 594)',
                'A3' => 'A3 (297 x 420)',
                'A4' => 'A4 (210 x 297)',
                'A5' => 'A5 (148 x 210)',
                'A6' => 'A6 (105 x 148)',
                'A7' => 'A7 (74 x 105)',
                'A8' => 'A8 (52 x 74)',
                'A9' => 'A9 (37 x 52)',
                'A10' => 'A10 (26 x 37)',
                'B0' => 'B0 (1000 x 1414)',
                'B1' => 'B1 (707 x 1000)',
                'B2' => 'B2 (500 x 707)',
                'B3' => 'B3 (353 x 500)',
                'B4' => 'B4 (250 x 353)',
                'B5' => 'B5 (176 x 250)',
                'B6' => 'B6 (125,x 176)',
                'B7' => 'B7 (88 x 125)',
                'B8' => 'B8 (62 x 88)',
                'B9' => 'B9 (44 x 62)',
                'B10' => 'B10 (31 x 44)',
                'C0' => 'C0 (917 x 1297)',
                'C1' => 'C1 (648 x 917)',
                'C2' => 'C2 (458 x 648)',
                'C3' => 'C3 (324 x 458)',
                'C4' => 'C4 (229 x 324)',
                'C5' => 'C5 (162 x 229)',
                'C6' => 'C6 (114 x 162)',
                'C7' => 'C7 (81 x 114)',
                'C8' => 'C8 (57 x 81)',
                'C9' => 'C9 (40 x 57)',
                'C10' => 'C10 (28 x 40)',
                'RA0' => 'RA0 (860 x 1220)',
                'RA1' => 'RA1 (610 x 860)',
                'RA2' => 'RA2 (430 x 610)',
                'SRA0' => 'SRA0 (900 x 1280)',
                'SRA1' => 'SRA1 (640 x 900)',
                'SRA2' => 'SRA2 (450 x 640)',
                'Letter' => 'Letter (215.9 x 279.4)',
                'Legal' => 'Legal (215.9 x 355.6)',
                'Ledger' => 'Ledger (279.4 x 431.8)',
            ), array('value' => 'A4')));
            
            $form->addElement(new Element\Number('Розмір шрифту', 'font_size', array(
                'value' => empty($values['font_size']) ? '12' : $values['font_size'],
            )));
            
            $form->addElement(new Element\Select('Стиль шрифту', 'font_style', array(
                'DejaVuSerif'
            )));
            
            $form->addElement(new Element\Textbox('Відступ зверху', 'margin_top', array(
                'value' => empty($values['margin_top']) ? '16' : $values['margin_top'],
            )));
            $form->addElement(new Element\Textbox('Відступ знизу', 'margin_bottom', array(
                'value' => empty($values['margin_bottom']) ? '16' : $values['margin_bottom'],
            )));
            $form->addElement(new Element\Textbox('Відступ зліва', 'margin_left', array(
                'value' => empty($values['margin_left']) ? '15' : $values['margin_left'],
            )));
            $form->addElement(new Element\Textbox('Відступ справа', 'margin_right', array(
                'value' => empty($values['margin_right']) ? '15' : $values['margin_right'],
            )));
            $form->addElement(new Element\Textbox('Відступ для верхнього колонтитулу', 'margin_header', array(
                'value' => empty($values['margin_header']) ? '9' : $values['margin_header'],
            )));
            $form->addElement(new Element\Textbox('Відступ для нижнього колонтитулу', 'margin_footer', array(
                'value' => empty($values['margin_footer']) ? '9' : $values['margin_footer'],
            )));
            
            $form->addElement(new Element\Textbox('Текст верхнього колонтитулу', 'header', array(
                'value' => empty($values['header']) ? '' : $values['header'],
            )));
            $form->addElement(new Element\Textbox('Текст нижнього колонтитулу', 'footer', array(
                'value' => empty($values['footer']) ? '' : $values['footer'],
            )));
            
            $form->addElement(new Element\Textbox('Текст водяного знаку', 'watermark_text', array(
                'value' => empty($values['watermark_text']) ? '' : $values['watermark_text'],
            )));
            $form->addElement(new Element\Textbox('Прозорість водяного знаку', 'watermark_opacity', array(
                'value' => empty($values['watermark_opacity']) ? '0.5' : $values['watermark_opacity'],
            )));
            
            $form->addElement(new Element\Textbox('Заголовок документу', 'doc_title', array(
                'value' => empty($values['doc_title']) ? '' : $values['doc_title'],
            )));
            
            $form->addElement(new Element\Textbox('Автор документу', 'doc_author', array(
                'value' => empty($values['doc_author']) ? '' : $values['doc_author'],
            )));
            
            $form->addElement(new Element\Textbox('Тема документу', 'doc_subject', array(
                'value' => empty($values['doc_subject']) ? '' : $values['doc_subject'],
            )));
            
            $form->addElement(new Element\Textbox('Ким створено документ', 'doc_creator', array(
                'value' => empty($values['doc_creator']) ? 'ЧНУ ім. Богдана Хмельницького' : $values['doc_creator'],
            )));
            
            $form->addElement(new Element\Textbox('Пароль', 'password', array(
                'value' => empty($values['password']) ? '' : $values['password'],
            )));
            
            $form->addElement(new Element\Textarea('Файли стилів для документу (css)', 'stylesheets', array(
                'value' => empty($values['stylesheets']) ? '' : $values['stylesheets'],
            )));
            
            $form->addElement(new Element\Select('Тип збереження:', 'save_option', array(
                'I' => 'Переглянути в браузері',
                'D' => 'Скачати',
            ), empty($values['save_option']) ? array('value' => $values['save_option']) : array('value' => $values['save_option'])));
            
            $this->addControls($form, $request);
        }

        return $form;
    }
    
    
    public function submit(Request $request)
    {
        $vars = array();
        $entity = $this->getEntity();
        $fields = $entity->getFields();
        $params = array();
        $id = $request->query->get('id');
        foreach ($fields as $field) {
            $params[$field] = $request->request->get($field);
        }
        if ($this->operation == 'create') {
            $parent = Container::get($this->entity)->getParent();
            if (!empty($parent)) {
                $vars['parent_id'] = $request->query->get('id');
            }
        } else {
            $parent = Container::get($this->entity)->getParent();
            if (!empty($parent)) {
                $parentId = Container::get($this->entity)->getParentId($id);
                $vars['parent_id'] = $parentId[0][$parent . '_id'];
            }
        }
        if ($this->operation == 'create') {
            $id = $entity->createEntity($params);
        }
        if ($this->operation == 'update') {
            $entity->updateEntity($params, array('id' => $id));
        }
        if ($this->operation == 'delete') {
            $entity->deleteEntity(array('id' => $id));
        }

        $step = $request->request->get('step');
        if ($step == 'finish') {
            $this->finishEvent($vars);
        }

    }
    
    protected function finishEvent($vars = array())
    {
        if (!empty($vars['parent_id'])) {
            Container::get('router')->redirect(explode('?', $_SESSION[$this->formName]['action'])[0] . '?id=' . $vars['parent_id']);
        }
        Container::get('router')->redirect($_SESSION[$this->formName]['action']);
    }

}

