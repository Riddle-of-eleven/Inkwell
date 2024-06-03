$(document).on('click', '#save-access', function () {
    let draft = $('input[type=checkbox][name=draft]').is(":checked") ? 1 : 0,
        status = $('input[type=radio][name=status]:checked').val(),
        editing = $('input[type=radio][name=editing]:checked').val();

    //console.log(draft, status, editing)

    $.ajax({
        url: 'http://inkwell/web/author/modify/set-access',
        type: 'post',
        data: {draft: draft, status: status, editing: editing},
        success: function (response) {
            if (response)
                if (response.success) showMessage('Данные успешно сохранены', 'success');
            else showMessage('Что-то пошло не так', 'warning');
        },
        error: function (error) {
            console.log(error);
        }
    });
});