/**
 * Plugin for CKeditor. Adds new items to context menu, which provides 
 * possibility to define structure of lab work.   
 */
CKEDITOR.plugins.add( 'lab_structure', {
    init: function( editor ) {

// Realization of main functionality
        function createSection(params) {
            var selectedText = params.editor.getSelection().getRanges()[0];
            var sectionTitle = new CKEDITOR.dom.element("span");
            var closeIcon = new CKEDITOR.dom.element("div");
            var sectionExists = editor.document.getById(params.bodyId);
            var sectionBody = new CKEDITOR.dom.element("span");
            var sectionWrapper = new CKEDITOR.dom.element("div");
                
            if (sectionExists) {
                alert(params.existErrorText);
                return;
            }
            
            if (selectedText.cloneContents().getChildCount() === 0) {
                return;
            }
            
            sectionTitle.setAttributes({id: params.titleId, style: 'background:'+params.sectionColor+'; color:'+params.titleTextColor+'; text-align:center; border-radius:3px 3px 0 0; position:relative; display:block;'});
            sectionTitle.setText(params.titleText);

            closeIcon.setAttributes({style: 'position:absolute; top:0; right:3px; width:20px;', onclick:'(elem=document.getElementById("'+params.titleId+'")).parentNode.removeChild(elem); document.getElementById("'+params.bodyId+'").parentNode.outerHTML = document.getElementById("'+params.bodyId+'").innerHTML;'});
            closeIcon.setText('x');
            sectionTitle.append(closeIcon);

            sectionBody.setAttributes({id: params.bodyId, style: 'border:1px solid '+params.sectionColor+'; border-radius:0 0 3px 3px; display:block;'});
            sectionBody.append(selectedText.cloneContents());
            
            sectionWrapper.append(sectionTitle);
            sectionWrapper.append(sectionBody);

            editor.insertElement(sectionWrapper);
            
            if (sectionWrapper.getNext() !== null) {
                sectionWrapper.getNext().setText(sectionWrapper.getNext().getText().replace(sectionBody.getLast().getText(), ''));
            }
        }

// Definition of parameters for section types.
        editor.addCommand( 'setAsTheme', {
            exec: function( editor ) {
                var params = {
                    'editor'    : editor,
                    'titleText' : 'Тема',
                    'existErrorText' : 'Тема документу вже обрана.',
                    'sectionColor' : 'green',
                    'titleTextColor' : '#ffffff',
                    'bodyId' : 'lab-theme-body',
                    'titleId' : 'lab-theme-title'
                };
                
                createSection(params);
            }
        });
        editor.addCommand( 'setAsType', {
            exec: function( editor ) {
                var params = {
                    'editor'    : editor,
                    'titleText' : 'Вид заняття',
                    'existErrorText' : 'Вид заняття вже обрано.',
                    'sectionColor' : 'green',
                    'titleTextColor' : '#ffffff',
                    'bodyId' : 'lab-type-body',
                    'titleId' : 'lab-type-title'
                };
                
                createSection(params);
            }
        });
        editor.addCommand( 'setAsPurpose', {
            exec: function( editor ) {
                var params = {
                    'editor'    : editor,
                    'titleText' : 'Мета',
                    'existErrorText' : 'Мета документу вже обрана.',
                    'sectionColor' : 'green',
                    'titleTextColor' : '#ffffff',
                    'bodyId' : 'lab-purpose-body',
                    'titleId' : 'lab-purpose-title'
                };
                
                createSection(params);
            }
        });
        editor.addCommand( 'setAsTheory', {
            exec: function( editor ) {
                var params = {
                    'editor'    : editor,
                    'titleText' : 'Теоретичний матеріал',
                    'existErrorText' : 'Теоретичний матеріал вже обрано',
                    'sectionColor' : 'green',
                    'titleTextColor' : '#ffffff',
                    'bodyId' : 'lab-theory-body',
                    'titleId' : 'lab-theory-title'
                };
                
                createSection(params);
            }
        });
        editor.addCommand( 'setAsOrderOfExecution', {
            exec: function( editor ) {
                var params = {
                    'editor'    : editor,
                    'titleText' : 'Порядок виконання',
                    'existErrorText' : 'Порядок виконання вже обрано.',
                    'sectionColor' : 'green',
                    'titleTextColor' : '#ffffff',
                    'bodyId' : 'lab-execution_order-body',
                    'titleId' : 'lab-execution_order-title'
                };
                
                createSection(params);
            }
        });
        editor.addCommand( 'setAsContentStructure', {
            exec: function( editor ) {
                var params = {
                    'editor'    : editor,
                    'titleText' : 'Структура змісту текстових розділів звітних матеріалів',
                    'existErrorText' : 'Структура змісту вже обрана.',
                    'sectionColor' : 'green',
                    'titleTextColor' : '#ffffff',
                    'bodyId' : 'lab-content_structure-body',
                    'titleId' : 'lab-content_structure-title'
                };
                
                createSection(params);
            }
        });
        editor.addCommand( 'setAsRequirementsForRegistration', {
            exec: function( editor ) {
                var params = {
                    'editor'    : editor,
                    'titleText' : 'Вимоги до оформлення роботи та опис процедури її захисту',
                    'existErrorText' : 'Вимоги до оформлення вже обрано.',
                    'sectionColor' : 'green',
                    'titleTextColor' : '#ffffff',
                    'bodyId' : 'lab-requirements-body',
                    'titleId' : 'lab-requirements-title'
                };
                
                createSection(params);
            }
        });
        editor.addCommand( 'setAsIndividualTasks', {
            exec: function( editor ) {
                var params = {
                    'editor'    : editor,
                    'titleText' : 'Варіанти індивідуальних завдань',
                    'existErrorText' : 'Варіанти індивідуальних завдань вже обрано.',
                    'sectionColor' : 'green',
                    'titleTextColor' : '#ffffff',
                    'bodyId' : 'lab-individual_variants-body',
                    'titleId' : 'lab-individual_variants-title'
                };
                
                createSection(params);
            }
        });
        editor.addCommand( 'setAsLiterature', {
            exec: function( editor ) {
                var params = {
                    'editor'    : editor,
                    'titleText' : 'Рекомендована література',
                    'existErrorText' : 'Рекомендована література вже обрана.',
                    'sectionColor' : 'green',
                    'titleTextColor' : '#ffffff',
                    'bodyId' : 'lab-literature-body',
                    'titleId' : 'lab-literature-title'
                };
                
                createSection(params);
            }
        });
        
// Removing excess items from context menu
        editor.removeMenuItem('paste');
        editor.removeMenuItem('copy');
        editor.removeMenuItem('cut');

// Registering items in context menu
        editor.addMenuItems({
            setAsTheme : {
               label   : 'Тема',
               command : 'setAsTheme',
               group   : 'image',
               order   : 1
            },
            setAsType : {
               label   : 'Вид заняття (семінар, практичне, лабораторна робота)',
               command : 'setAsType',
               group   : 'image',
               order   : 1
            },
            setAsPurpose : {
               label   : 'Мета',
               command : 'setAsPurpose',
               group   : 'image',
               order   : 1
            },
            setAsTheory : {
               label   : 'Теоретичний матеріал',
               command : 'setAsTheory',
               group   : 'image',
               order   : 1
            },
            setAsOrderOfExecution : {
               label   : 'Порядок виконання роботи',
               command : 'setAsOrderOfExecution',
               group   : 'image',
               order   : 1
            },
            setAsContentStructure : {
               label   : 'Структура змісту текстових розділів звітних матеріалів',
               command : 'setAsContentStructure',
               group   : 'image',
               order   : 1
            },
            setAsRequirementsForRegistration : {
               label   : 'Вимоги до оформлення роботи та опис процедури її захисту',
               command : 'setAsRequirementsForRegistration',
               group   : 'image',
               order   : 1
            },
            setAsIndividualTasks : {
               label   : 'Варіанти індивідуальних завдань',
               command : 'setAsIndividualTasks',
               group   : 'image',
               order   : 1
            },
            setAsLiterature : {
               label   : 'Рекомендована література',
               command : 'setAsLiterature',
               group   : 'image',
               order   : 1
            }
        });
        
// Registering listeners
        editor.contextMenu.addListener( function( element, selection ) {
            return { 
               setAsTheme : CKEDITOR.TRISTATE_OFF 
            };
        });
        editor.contextMenu.addListener( function( element, selection ) {
            return { 
               setAsType : CKEDITOR.TRISTATE_OFF 
            };
        });
        editor.contextMenu.addListener( function( element, selection ) {
            return { 
               setAsPurpose : CKEDITOR.TRISTATE_OFF 
            };
        });
        editor.contextMenu.addListener( function( element, selection ) {
            return { 
               setAsTheory : CKEDITOR.TRISTATE_OFF 
            };
        });
        editor.contextMenu.addListener( function( element, selection ) {
            return { 
               setAsOrderOfExecution : CKEDITOR.TRISTATE_OFF 
            };
        });
        editor.contextMenu.addListener( function( element, selection ) {
            return { 
               setAsContentStructure : CKEDITOR.TRISTATE_OFF 
            };
        });
        editor.contextMenu.addListener( function( element, selection ) {
            return { 
               setAsRequirementsForRegistration : CKEDITOR.TRISTATE_OFF 
            };
        });
        editor.contextMenu.addListener( function( element, selection ) {
            return { 
               setAsIndividualTasks : CKEDITOR.TRISTATE_OFF 
            };
        });
        editor.contextMenu.addListener( function( element, selection ) {
            return { 
               setAsLiterature : CKEDITOR.TRISTATE_OFF 
            };
        });
        
        
    }
});