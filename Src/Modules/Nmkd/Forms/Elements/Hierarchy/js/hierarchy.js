$(function(){
    marker = $('.hierarchy-wrapper .hierarchy-groups li.active');
    wrapper = $(this).closest('.hierarchy-wrapper');
    $('.marker', wrapper).attr('value', marker);
});

$('.hierarchy-wrapper').on('click','.hierarchy-groups li',function(){
    
    $(this).parent().children().removeClass('active');
    $(this).addClass('active');
    
    marker = $(this).attr('value');
    wrapper = $(this).closest('.hierarchy-wrapper');
    
    $('.marker', wrapper).attr('value', marker);
});

$('.hierarchy-wrapper').on('click', '.ui-sortable li', function(){
    wrapper = $(this).closest('.hierarchy-wrapper');
    marker = $('.marker', wrapper).attr('value');
    initialValue = $('input', this).attr('value');
    settedValue = initialValue.substring(0, initialValue.indexOf('-')+1) + marker;
    $('input', this).attr('value', settedValue);
    
    $('.header', this).text($('.hierarchy-groups li.active', wrapper).text());
});