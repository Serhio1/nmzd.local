/**
 * Script for checking column in CheckboxMatrix PFBC element.
 */
$('.checkbox-matrix').on('change', '.check-col', function(){
    id = $(this).prop('id');
    horIndex = id.slice(id.indexOf("-")+1, id.length);
    chMatrix = $(this).closest('.checkbox-matrix');
    if (this.checked) {
        $('.check-matrix-element[id$="'+horIndex+'"]', chMatrix).prop('checked',true);
    } else {
        $('.check-matrix-element[id$="'+horIndex+'"]', chMatrix).prop('checked',false);
    }
});
