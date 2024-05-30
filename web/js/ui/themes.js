$('.change-theme').click(function () {
    let modal = $('.change-theme-modal')[0];

    $.ajax({
        type: 'post',
        url: 'http://inkwell/web/main/get-themes',
        success: function (response) {
            if (response.success) {
                let content = '';
                response.data.forEach(function (element) {
                    content += `<button class="ui button block theme-item" theme="${element.system_name}">
                                    ${element.title}
                                    ${element.svg} 
                                </button>`
                });
                $('.themes-container').html(content);
                modal.showModal();
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
});

$('#close-theme-change').click(function () {
    let modal = $('.change-theme-modal')[0];
    modal.close();
});

$('.themes-container').on('click', '.theme-item', function () {
    $.ajax({
        type: 'post',
        url: 'http://inkwell/web/main/change-theme',
        data: {theme: $(this).attr('theme')},
        success: function (response) {
            if (response.old_theme)
                $(`link[href="/web/css/themes/${response.old_theme}.css"]`).attr('href', `/web/css/themes/${response.theme}.css`);
        },
        error: function (error) {
            console.log(error);
        }
    });
});