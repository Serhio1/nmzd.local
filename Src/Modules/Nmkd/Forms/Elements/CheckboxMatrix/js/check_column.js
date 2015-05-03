/**
 * Script for checking column in CheckboxMatrix PFBC element.
 */
$('.checkbox-matrix').on('change', '.check-col', function(){
    id = $(this).prop('id');
    horIndex = id.slice(id.indexOf("-")+1, id.length);
    currentNum = id.slice(0, id.indexOf("-"));
    currentNum = (currentNum === '1') ? '2' : currentNum;
    chMatrix = $(this).closest('.checkbox-matrix');
    
    elements = $('.check-matrix-element[id$="'+horIndex+'"]', chMatrix);
    for (var i=currentNum-1; i<elements.length; i++) {
        if (this.checked) {
            element = $(elements[i]);
            checked = $(this);
            if (element.hasClass('check-col')) {
                break;
            }
            element.prop('checked',true);
        } else {
            element = $(elements[i]);
            checked = $(this);
            if (element.hasClass('check-col')) {
                break;
            }
            element.prop('checked',false);
        }
    } 
});
