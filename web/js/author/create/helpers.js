// загружает в секцию контента текущий шаг
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

// подсчитывает и устанавливает количество символов около ввода
function countSymbolsFromField(field, total) {
    let count = field.val().length;
    let place = field.closest('.metadata-item').find('.content-limit');
    place.html(total - count);
}

// сохраняет вводимые данные
function saveData(data, session_key) {
    $.ajax({
        url: 'index.php?r=author/create/save-data',
        type: 'post',
        data: {data: data, session_key: session_key},
    });
}

// получает имя сессионного ключа из id
function getSessionKeyFromId(element) {
    let id = element.attr('id').split('-');
    return id[id.length - 1];
}