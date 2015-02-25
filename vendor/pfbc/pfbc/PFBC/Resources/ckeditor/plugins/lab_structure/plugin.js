/**
 * Plugin for CKeditor. Adds new items to context menu, which provides 
 * possibility to define structure of lab work.   
 */

CKEDITOR.plugins.add( 'lab_structure', {
    init: function( editor ) {

// Realization of main functionality
        editor.addCommand( 'setAsTheme', {
            exec: function( editor ) {
                var range = editor.getSelection().getRanges()[ 0 ],
                    el = editor.document.createElement( 'div' );

                el.append( range.cloneContents() );
                var edata = editor.getData();

                var replaced_text = edata.replace(el.getHtml(), '<div id="lab-section" style="border:1px solid green; border-radius:3px;"><div id="theme" style="background:green; color:#fff; text-align:center;">Тема</div>' + el.getHtml() + '</div>');

                editor.setData(replaced_text);
            }
        });
        editor.addCommand( 'setAsType', {
            exec: function( editor ) {
                var now = new Date();
                    range = editor.getSelection().getRanges()[ 0 ],
                    el = editor.document.createElement( 'div' );

                el.append( range.cloneContents() );
                var edata = editor.getData();

                var replaced_text = edata.replace(el.getHtml(), '<div id="lab-section" style="border:1px solid green; border-radius:3px;"><div id="theme" style="background:green; color:#fff; text-align:center;">Вид заняття</div>' + el.getHtml() + '</div>');

                editor.setData(replaced_text);
            }
        });
        editor.addCommand( 'setAsPurpose', {
            exec: function( editor ) {
                var now = new Date();
                    range = editor.getSelection().getRanges()[ 0 ],
                    el = editor.document.createElement( 'div' );

                el.append( range.cloneContents() );
                var edata = editor.getData();

                var replaced_text = edata.replace(el.getHtml(), '<div id="lab-section" style="border:1px solid green; border-radius:3px;"><div id="theme" style="background:green; color:#fff; text-align:center;">Мета</div>' + el.getHtml() + '</div>');

                editor.setData(replaced_text);
            }
        });
        editor.addCommand( 'setAsTheory', {
            exec: function( editor ) {
                var now = new Date();
                    range = editor.getSelection().getRanges()[ 0 ],
                    el = editor.document.createElement( 'div' );

                el.append( range.cloneContents() );
                var edata = editor.getData();

                var replaced_text = edata.replace(el.getHtml(), '<div id="lab-section" style="border:1px solid green; border-radius:3px;"><div id="theme" style="background:green; color:#fff; text-align:center;">Теоретичний матеріал</div>' + el.getHtml() + '</div>');

                editor.setData(replaced_text);
            }
        });
        editor.addCommand( 'setAsOrderOfExecution', {
            exec: function( editor ) {
                var now = new Date();
                    range = editor.getSelection().getRanges()[ 0 ],
                    el = editor.document.createElement( 'div' );

                el.append( range.cloneContents() );
                var edata = editor.getData();

                var replaced_text = edata.replace(el.getHtml(), '<div id="lab-section" style="border:1px solid green; border-radius:3px;"><div id="theme" style="background:green; color:#fff; text-align:center;">Порядок виконання роботи</div>' + el.getHtml() + '</div>');

                editor.setData(replaced_text);
            }
        });
        editor.addCommand( 'setAsContentStructure', {
            exec: function( editor ) {
                var now = new Date();
                    range = editor.getSelection().getRanges()[ 0 ],
                    el = editor.document.createElement( 'div' );

                el.append( range.cloneContents() );
                var edata = editor.getData();

                var replaced_text = edata.replace(el.getHtml(), '<div id="lab-section" style="border:1px solid green; border-radius:3px;"><div id="theme" style="background:green; color:#fff; text-align:center;">Структура змісту текстових розділів звітних матеріалів</div>' + el.getHtml() + '</div>');

                editor.setData(replaced_text);
            }
        });
        editor.addCommand( 'setAsRequirementsForRegistration', {
            exec: function( editor ) {
                var now = new Date();
                    range = editor.getSelection().getRanges()[ 0 ],
                    el = editor.document.createElement( 'div' );

                el.append( range.cloneContents() );
                var edata = editor.getData();

                var replaced_text = edata.replace(el.getHtml(), '<div id="lab-section" style="border:1px solid green; border-radius:3px;"><div id="theme" style="background:green; color:#fff; text-align:center;">Вимоги до оформлення роботи та опис процедури її захисту</div>' + el.getHtml() + '</div>');

                editor.setData(replaced_text);
            }
        });
        editor.addCommand( 'setAsIndividualTasks', {
            exec: function( editor ) {
                var now = new Date();
                    range = editor.getSelection().getRanges()[ 0 ],
                    el = editor.document.createElement( 'div' );

                el.append( range.cloneContents() );
                var edata = editor.getData();

                var replaced_text = edata.replace(el.getHtml(), '<div id="lab-section" style="border:1px solid green; border-radius:3px;"><div id="theme" style="background:green; color:#fff; text-align:center;">Варіанти індивідуальних завдань</div>' + el.getHtml() + '</div>');

                editor.setData(replaced_text);
            }
        });
        editor.addCommand( 'setAsLiterature', {
            exec: function( editor ) {
                var now = new Date();
                    range = editor.getSelection().getRanges()[ 0 ],
                    el = editor.document.createElement( 'div' );

                el.append( range.cloneContents() );
                var edata = editor.getData();

                var replaced_text = edata.replace(el.getHtml(), '<div id="lab-section" style="border:1px solid green; border-radius:3px;"><div id="theme" style="background:green; color:#fff; text-align:center;">Рекомендована література</div>' + el.getHtml() + '</div>');

                editor.setData(replaced_text);
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