function loadStepByName(url) {
    $.ajax({
        url: 'index.php?r=author/create/load-step-' + url,
        type: 'post',
        success: function (response) {
            $(`.step-content`).html(response);
        },
        error: function (error) {
            console.error('Ошибка: ', error);
        }
    });

    $.ajax({
        url: 'index.php?r=author/create/remember-step',
        type: 'post',
        data: {step: url},
    });
}

// должен вернуть количество оставшихся символов?
function countSymbolsFromField(field, total) {
    let count = field.val().length;
    let place = field.closest('.metadata-item').find('.content-limit');
    place.html(total - count);
}