(function($) {
    $('.autosubmit').on('click', '.autosave-btn', function(e){
        postAjaxForm();
    });
    var autosaveInterval = setInterval(function(){ postAjaxForm(); }, parseInt($('.timeout').val())*1000);
    $('.autosubmit').on('blur', '.timeout', function(e){
        clearInterval(autosaveInterval);
        autosaveInterval = setInterval(function(){ postAjaxForm(); }, parseInt($('.timeout').val())*1000);
    });
    
    
    function postAjaxForm() {
        $('.save-msg').aje()
            .setData({'key':'autosave', 'data':$('.timeout').closest('form').serialize()})
            .fire();
        setTimeout(function(){ $('.save-msg').html(''); }, 3000);
    }
})(jQuery);


