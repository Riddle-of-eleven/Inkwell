// обработка сохранения введённых данных в сессии
content.on('input', '.direct-to-session input[type=text], .direct-to-session textarea', function () {
     saveData($(this).val(), getSessionKeyFromId($(this)));
});

content.on('change', '.direct-to-session input[type=radio]', function () {
     saveData($(this).val(), getSessionKeyFromId($(this).closest('.input-block-list')));
});