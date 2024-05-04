$('.tab').click(function() {
    let id = $(this).attr('data-tab');
    let content = $('.tab-content[data-tab="'+ id +'"]');

    $('.tab.active-tab').removeClass('active-tab');
    $(this).addClass('active-tab');

    $('.tab-content.active-tab').removeClass('active-tab');
    content.addClass('active-tab');
});

$('.step').click(function () {
    let id = $(this).attr('data-tab'), content = $('.step-content[data-tab="'+ id +'"]');

    $('.step.active-step').removeClass('active-step');
    $(this).addClass('active-step');

    $('.step-content.active-step-content').removeClass('active-step-content');
    content.addClass('active-step-content');
});