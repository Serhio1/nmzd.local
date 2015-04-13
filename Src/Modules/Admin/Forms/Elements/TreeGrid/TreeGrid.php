<?php

namespace Src\Modules\Admin\Forms\Elements\TreeGrid;

use PFBC\Element;
use App\Core\Router;

class TreeGrid extends Element {
    protected $options;
    
    protected $name;
    
    public function getCSSFiles() {
        return array(
            Router::buildUrl('Src/Modules/Admin/Forms/Elements/TreeGrid/css/easyui.css'),
            Router::buildUrl('Src/Modules/Admin/Forms/Elements/TreeGrid/css/icon.css'),
        );
    }
    
    public function getJSFiles() {
        return array(
            Router::buildUrl('Src/Modules/Admin/Forms/Elements/TreeGrid/js/jquery.min.js'),
            Router::buildUrl('Src/Modules/Admin/Forms/Elements/TreeGrid/js/jquery.easyui.min.js'),
            Router::buildUrl('Src/Modules/Admin/Forms/Elements/TreeGrid/js/treegrid-dnd.js'),
        );
    }

    /**
     * 
     * @param type $label
     * @param type $name
     * @param array $options - json array, compatible with easy ui treegrid element
     * @param array $properties
     */
    public function __construct($label, $name, $options, array $properties = null) {
            $this->options = $options;
            $this->name = $name;
            parent::__construct($label, $name, $properties);
    }
    
    public function render() {
        $markup = '';
        if (!empty($this->options['buttons']) && $this->options['buttons']) {
            $markup .= '<div style="margin:20px 0;">
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="append()">New</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="removeIt()">Delete</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="edit()">Edit</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="save()">Save</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancel()">Cancel</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="$(\'#' . $this->name . '\').treegrid(\'unselectAll\')">Unselect</a>
        </div>';
        }
        
        $markup .= '<table id="' . $this->name . '" class="easyui-treegrid" style="margin:0;width:100%;height:300px;"
                        data-options="';
        
        $defaultParams = array(
            'rownumbers' => 'true',
            'animate' => 'false',
            'collapsible' => 'true',
            'fitColumns' => 'true',
            'url' => '',
            'method' => 'get',
            'idField' => 'id',
            'treeField' => 'name',
            'showFooter' => 'false',
            'contextMenu' => 'true',
            'dragAndDrop' => 'true',
        );
        
        
        
        if (!empty($this->options['params'])) {
            $this->options['params'] = array_merge($defaultParams, $this->options['params']);
            foreach ($this->options['params'] as $pName => $pVal) {
                $markup .= $pName . ': \'' . $pVal . '\',';
            }
            if ($this->options['params']['contextMenu'] == 'true') {
                $markup .= 'onContextMenu: onContextMenu,';
            }
            if ($this->options['params']['dragAndDrop'] == 'true') {
                $markup .= 'onLoadSuccess: function(row){$(this).treegrid(\'enableDnd\', row?row.id:null);},';
            }
            $markup = rtrim($markup, ',');
        } else {
            echo 'PFBC TreeGrid error: options[params] is required.';
            return;
        }
        
        $markup .= '"><thead><tr>';
        foreach ($this->options['fields'] as $name => $field) {
            $label = empty($field['label']) ? '' : $field['label'];
            $editor = empty($field['editor']) ? '' : $field['editor'];
            $width = empty($field['width']) ? '60' : $field['width'];
            $markup .= '<th data-options="field:\'' . $name . '\',width:' . $width . ',editor:\'' . $editor . '\'">' . $label . '</th>';
        }          
        $markup .= '</tr>
                </thead>
        </table>';
        
        if ($this->options['params']['contextMenu'] == 'true') {
            $markup .= '<div id="mm" class="easyui-menu" style="width:120px;">
                <div onclick="append()" data-options="iconCls:\'icon-add\'">Append</div>
                <div onclick="removeIt()" data-options="iconCls:\'icon-remove\'">Remove</div>
                <div class="menu-sep"></div>
                <div onclick="edit()">Edit</div>
                <div onclick="save()">Save</div>
                <div onclick="cancel()">Cancel</div>
                <div class="menu-sep"></div>
                <div onclick="collapse()">Collapse</div>
                <div onclick="expand()">Expand</div>
        </div>';
        }
        
        
        
        $markup .= '<script type="text/javascript">
                function formatProgress(value){
                if (value){
                        var s = \'<div style="width:100%;border:1px solid #ccc">\' +
                                        \'<div style="width:\' + value + \'%;background:#cc0000;color:#fff">\' + value + \'%\' + \'</div>\'
                                        \'</div>\';
                        return s;
                } else {
                        return \'\';
                }
                }
                var editingId;
                function edit(){
                        
                        if (editingId != undefined){
                                $(\'#' . $this->name . '\').treegrid(\'select\', editingId);
                                return;
                        }
                        var row = $(\'#' . $this->name . '\').treegrid(\'getSelected\');
                        if (row){
                                editingId = row.id;
                                
                                var t = $(\'#' . $this->name . '\');
                                t.treegrid(\'beginEdit\',editingId);
                                var eds = t.treegrid(\'getEditors\',editingId);
                                for(var i=0;i<eds.length;i++){
                                    $(eds[i].target).bind(\'mousedown\',function(e){
                                        e.stopPropagation();
                                    });
                                }
                        }
                }
                function save(){
                        if (editingId != undefined){
                                var t = $(\'#' . $this->name . '\');
                                t.treegrid(\'endEdit\', editingId);
                                editingId = undefined;
                                var persons = 0;
                                var rows = t.treegrid(\'getChildren\');
                                for(var i=0; i<rows.length; i++){
                                        var p = parseInt(rows[i].persons);
                                        if (!isNaN(p)){
                                                persons += p;
                                        }
                                }
                                var frow = t.treegrid(\'getFooterRows\')[0];
                                frow.persons = persons;
                                t.treegrid(\'reloadFooter\');
                        }
                }
                function cancel(){
                        if (editingId != undefined){
                                $(\'#' . $this->name . '\').treegrid(\'cancelEdit\', editingId);
                                editingId = undefined;
                        }
                }
                function getData(){
                    $(\'#' . $this->name . '_text\').val(\'{\"rows\":\' + JSON.stringify($(\'#' . $this->name . '\').treegrid(\'getData\')) + \'}\');
                }
        </script>

        <script type="text/javascript">
                function formatProgress(value){
                if (value){
                        var s = \'<div style="width:100%;border:1px solid #ccc">\' +
                                        \'<div style="width:\' + value + \'%;background:#cc0000;color:#fff">\' + value + \'%\' + \'</div>\'
                                        \'</div>\';
                        return s;
                } else {
                        return \'\';
                }
                }
                function onContextMenu(e,row){
                        e.preventDefault();
                        $(this).treegrid(\'select\', row.id);
                        $(\'#mm\').menu(\'show\',{
                                left: e.pageX,
                                top: e.pageY
                        });
                }
                var idIndex = 100;
                function append(){
                        var d1 = new Date();
                        var d2 = new Date();
                        var lastRoot, children, lastChild;
                        var parentId;
                        d2.setMonth(d2.getMonth()+1);
                        var roots = $(\'#' . $this->name . '\').treegrid(\'getRoots\');
                        if (roots) {
                            lastRoot = roots[roots.length-1];
                            children = $(\'#' . $this->name . '\').treegrid(\'getChildren\', lastRoot.id);
                            if (children) {
                                lastChild = children[children.length-1];
                            }
                        }
                        parentId = (lastChild)?lastChild.id+1:(lastRoot)?lastRoot.id+1:1;
                        
                        
                        var node = $(\'#' . $this->name . '\').treegrid(\'getSelected\');
                        $(\'#' . $this->name . '\').treegrid(\'append\',{
                                parent: (node)?node.id:null,
                                data: [{
                                        id: parentId,';
                                $markup .= $this->options['params']['treeField'] . ': \'New\'';
                                $markup .= '}]
                        })
                }
                function removeIt(){
                        var node = $(\'#' . $this->name . '\').treegrid(\'getSelected\');
                        if (node){
                                $(\'#' . $this->name . '\').treegrid(\'remove\', node.id);
                        }
                }
                function collapse(){
                        var node = $(\'#' . $this->name . '\').treegrid(\'getSelected\');
                        if (node){
                                $(\'#' . $this->name . '\').treegrid(\'collapse\', node.id);
                        }
                }
                function expand(){
                        var node = $(\'#' . $this->name . '\').treegrid(\'getSelected\');
                        if (node){
                                $(\'#' . $this->name . '\').treegrid(\'expand\', node.id);
                        }
                }
        </script>';
        $markup .= '<script type="text/javascript">
            JSON.stringify = JSON.stringify || function (obj) {
    var t = typeof (obj);
    if (t != "object" || obj === null) {
        // simple data type
        if (t == "string") obj = \'"\'+obj+\'"\';
        return String(obj);
    }
    else {
        // recurse array or object
        var n, v, json = [], arr = (obj && obj.constructor == Array);
        for (n in obj) {
            v = obj[n]; t = typeof(v);
            if (t == "string") v = \'"\'+v+\'"\';
            else if (t == "object" && v !== null) v = JSON.stringify(v);
            json.push((arr ? "" : \'"\' + n + \'":\') + String(v));
        }
        return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
    }
};</script>';
        $markup .= '<script type="text/javascript">
                $("#' . $this->options['form_id'] . '").submit(function( event ) {
                    getData();
                });
                $(document).ready(function() {
                    $(window).keydown(function(event){
                      if(event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                      }
                    });
                  });
            </script>';
        
        $markup .= '<textarea style="display:none;" id="' . $this->name . '_text" name="' . $this->name . '"></textarea>';
        echo $markup;
    }
}