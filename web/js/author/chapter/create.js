const quill = new Quill('#editor', {
    modules: {
        toolbar: '#toolbar-container'
    },
    theme: 'snow',
    placeholder: 'Введите текст главы сюда...'
});