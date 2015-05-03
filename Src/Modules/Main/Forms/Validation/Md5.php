<?php

namespace Src\Modules\Main\Forms\Validation;

class Md5 extends \PFBC\Validation\RegExp
{
    public function isValid($value) {
        if($this->isNotApplicable($value) || preg_match($this->pattern, md5($value))) {
            return true;
        }
        return false;
    }
}