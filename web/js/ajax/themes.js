$('.change-theme').click(function () {
    let modal = $('.change-theme-modal');

    $.ajax({
       type: 'post',
       url: 'index.php?r=main/change-theme',

    });
});