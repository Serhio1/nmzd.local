(function( $ ){
$(document).on('click', '.ajax-submit', function(){
    $(this).closest('.block').ajaxEngine({code1:'form_submit'},{
        url:$(this).closest('form').attr('action'),
        data: $(this).closest('form').serialize()
    });
});
})(jQuery);
