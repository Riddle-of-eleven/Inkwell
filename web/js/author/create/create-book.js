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
    // фэндомы
    if ($(e.target).attr('id') !== getNameFromId(fandom) && !checkClosest(e.target, fandom, '.dropdown-list'))
        removeDropdownList($(fandom));
});

// открытие выпадающих списков по типу метаданных
content.on('click', '.chosen-items-to-session [meta-type]', function() {
    let input = $(this).closest('.metadata-item').find('input');
    createDropdown(input, createTitleItems, $(this).attr('meta-type'));
    //console.log($(this).attr('meta-type'))
});

// добавление выбранных элементов по клику
content.on('click', '.chosen-items-to-session:not(.fandom-item) .dropdown-item', function () {
    addSelectedUnit($(this), createTitleItems);
});
// удаление выбранных элементов по клику
content.on('click', '.chosen-items-to-session .cancel-icon', function () {
    removeSelectedUnit($(this));
});



// ФЭНДОМНЫЕ СВЕДЕНИЯ
// переключение видимости фэндомной секции
content.on('change', book_type + ' input[type=radio]', function () {
    if ($(this).val() === '1') $('.book-type-depend').addClass('hidden');
    else $('.book-type-depend').removeClass('hidden');
});
// добавление выбранного фэндома по клику
content.on('click', '.fandom-item .dropdown-item', function () {
    addSelectedFandomUnit($(this), createTitleItems);
});
// удаление выбранного фэндома по клику
content.on('click', '.fandom-item .delete-icon', function () {
    let meta = $(this).closest('.metadata-item-selected-unit').attr('meta');
    removeSelectedUnit($(this), meta);
});

// сохранение выбранных первоисточников
content.on('change', origins + ' input', function () {
    saveData($(this).val(), 'origins', true);
})
