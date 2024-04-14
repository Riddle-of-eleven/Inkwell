$('.tab').click(function() {
    let id = $(this).attr('data-tab');
    let content = $('.tab-content[data-tab="'+ id +'"]');

    $('.tab.active-tab').removeClass('active-tab'); // 1
    $(this).addClass('active-tab'); // 2

    $('.tab-content.active-tab').removeClass('active-tab'); // 3
    content.addClass('active-tab'); // 4
});