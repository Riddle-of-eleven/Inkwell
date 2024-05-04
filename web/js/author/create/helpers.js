function loadStepByName(name) {
    $.ajax({
        url: 'index.php?r=author/create/load-step',
        data: {step: name},
        type: 'post',
        success: function (response) {
            $(`.step-content`).html(response);
        },
        error: function (error) {
            console.error('Ошибка: ', error);
        }
    });
}