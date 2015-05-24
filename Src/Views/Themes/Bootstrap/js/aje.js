(function( $ ){
    $.fn.aje = function(){
        var target = $(this);
        var ajaxEngine = {
            'fire':function(code, url){
                code = code||'';
                url = url||'';
                $.post(url,
                    {
                        code:code,
                        ajaxData:$.data(target, 'ajeData')
                    },
                    function(response){
                        target.html(response);
                    });
                    
                return this;
            },
            'setData':function(data){
                $.data(target, 'ajeData', data);
                return this;
            },
            'setMenu':function(menu){
                $(menu).on('click', 'a', function(e){
                    var clicked = $(e.target);
                    var menu = clicked.closest('ul')/*$(menu)*/;
                    e.preventDefault();
                    $(menu).children().removeClass('active');
                    clicked.addClass('active');
                    clicked.parent().addClass('active');
                    ajaxEngine.fire('', clicked.attr('href')); 
                });
                return this;
            }
        };
        
        return ajaxEngine;
    };
})( jQuery );