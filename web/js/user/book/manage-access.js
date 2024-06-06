$(document).on('click', '#save-access', function () {
    let draft = $('input[type=checkbox][name=draft]').is(":checked") ? 1 : 0,
        status = $('input[type=radio][name=status]:checked').val(),
        editing = $('input[type=radio][name=editing]:checked').val(),
        preview = $('#preview-book');

    //console.log(draft, status, editing)

    $.ajax({
        url: 'http://inkwell/web/author/modify/set-access',
        type: 'post',
        data: {draft: draft, status: status, editing: editing},
        success: function (response) {
            if (response) {
                if (response.success) showMessage('Данные успешно сохранены', 'success');
                if (response.is_draft === '0') preview.removeClass('disabled-button');
                else preview.addClass('disabled-button');

                //console.log(response.is_draft === '0')
            }
            else showMessage('Что-то пошло не так', 'warning');
        },
        error: function (error) {
            console.log(error);
        }
    });
});