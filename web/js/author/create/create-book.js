// загрузка вкладок
$('.step').click(function () {
    loadStepByName($(this).data('step'));
});


// обработка сохранения введённых данных в сессии
content.on('input', '.direct-to-session input[type=text], .direct-to-session textarea', function () {
    saveData($(this).val(), getSessionKeyFromId($(this)));
});
content.on('change', '.direct-to-session input[type=radio]', function () {
    saveData($(this).val(), getSessionKeyFromId($(this).closest('.input-block-list')));
});


// открытие выпадающих списков по клику
content.on('click input', '.chosen-items-to-session input[type=text]', function () {
    createDropdown($(this), createTitleItems);
});
// закрытие выпадающих списков по клику
$(document).on('click', function (e) {
    // жанры
    if ($(e.target).attr('id') !== getNameFromId(genres) && !checkClosest(e.target, genres, '.dropdown-list'))
        removeDropdownList($(genres));
    // теги
    if ($(e.target).attr('id') !== getNameFromId(tags) && !checkClosest(e.target, tags, '.dropdown-list'))
        removeDropdownList($(tags));
});

// добавление выбранных элементов по клику
content.on('click', '.chosen-items-to-session .dropdown-item', function () {
    addSelectedUnit($(this), createTitleItems);
});
// удаление выбранных элементов по клику
content.on('click', '.chosen-items-to-session .cancel-icon', function () {
    removeSelectedUnit($(this));
});