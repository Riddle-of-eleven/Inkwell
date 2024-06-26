const quill = new Quill('#editor', {
    modules: {
        toolbar: '#toolbar-container',
    },
    theme: 'snow',
    placeholder: 'Введите текст главы сюда...'
});
quill.on('text-change', function(delta, oldDelta, source) {
    // выравнивание по умолчанию по левому краю
    if (source === 'user') quill.format('align', 'left');
});


// обработка загрузки файла
const label = $('.upload-container'),
    input = $('#create-chapter-file');
label.on('dragover', function (e) {
    e.preventDefault(); e.stopPropagation();
    $(this).addClass('dragover')
});
label.on('dragleave', function (e) {
    e.preventDefault(); e.stopPropagation();
    $(this).removeClass('dragover');
});
label.on('drop', function (e) {
    e.preventDefault(); e.stopPropagation();
    label.removeClass('dragover');
    let files = e.originalEvent.dataTransfer.files;
    if (files.length > 0) {
        input[0].files = files;
        input.trigger('change');
    }
});

// функция, отвечающая за передачу загруженного файла на сервер
input.on('change', function(e) {
    let file = e.target.files[0];
    if (file) {
        let data = new FormData();
        data.append('file', file);
        $.ajax({
            url: 'process-file',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {
                //console.log(response);
                let editor = $('.ql-editor');
                if (response) editor.html(response);
                setCaret(editor[0]);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
});