<?php

namespace Src\Modules\Nmkd\Forms\Elements\TextareaUpload;

use PFBC\Element\Textarea;

class TextareaUpload extends Textarea {

	public function render() {
        $tpl = '';
        $tpl .= '<input name="file" type="file" id="file-upload" />';
        $tpl .= "<textarea" . $this->getAttributes("value") . ">";
        if(!empty($this->_attributes["value"]))
            $tpl .= $this->filter($this->_attributes["value"]);
        $tpl .= "</textarea>";
        
        $tpl .= '<script>
$(\'body\').on(\'change\', \'#file-upload\', function(e){
        e.preventDefault();
        var formData = new FormData($(this).parents(\'form\')[0]);
        $.ajax({
            url: \'http://nmzd.local/main/file-content\',
            type: \'POST\',
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                return myXhr;
            },
            success: function (data) {
                if ($("#' . $this->getAttribute("id") . '").html() === \'\') {
                    $("#' . $this->getAttribute("id") . '").append(data);
                } else {
                    $("#' . $this->getAttribute("id") . '").append(\'\n\');
                    $("#' . $this->getAttribute("id") . '").append(data);
                }
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
});
</script>';
        
        echo $tpl;
    }
}