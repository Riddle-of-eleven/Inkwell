const dialog = $('#set-appearance'),
    open = $('#open-set-appearance'),
    close = dialog.find('.close-button');

open.click(() => { dialog[0].showModal(); });
close.click(() => { dialog[0].close(); });


$('.font-block').on('click', function () {
    let font = $(this).attr('data-font');
    $.ajax({
        url: 'http://inkwell/web/main/change-font',
        type: 'post',
        data: {font: font},
        success: function (response) {
            //console.log(response)
            if (response.old_font)
                $(`link[href="/web/css/parts/book/reader_${response.old_font}.css"]`)
                    .attr('href', `/web/css/parts/book/reader_${font}.css`);
        },
        error: function (error) {
            console.log(error);
        }
    });
});