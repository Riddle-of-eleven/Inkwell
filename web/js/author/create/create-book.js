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
content.on('click input', '.chosen-items-to-session:not(.pairings-item) input[type=text]', function () {
    if (getSessionKeyFromId($(this)) === 'characters') createDropdown($(this), createNameItems);
    else createDropdown($(this), createTitleItems);
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
    if ($(e.target).attr('id') !== getNameFromId(fandoms) && !checkClosest(e.target, fandoms, '.dropdown-list'))
        removeDropdownList($(fandoms));
    // персонажи
    if ($(e.target).attr('id') !== getNameFromId(characters) && !checkClosest(e.target, characters, '.dropdown-list'))
        removeDropdownList($(characters));

    // фэндомные спец. теги
    if ($(e.target).attr('id') !== getNameFromId(fandom_tags) && !checkClosest(e.target, fandom_tags, '.dropdown-list'))
        removeDropdownList($(fandom_tags));
});

// открытие выпадающих списков по типу метаданных
content.on('click', '.chosen-items-to-session [meta-type]', function() {
    let input = $(this).closest('.metadata-item').find('input');
    createDropdown(input, createTitleItems, $(this).attr('meta-type'));
});

// добавление выбранных элементов по клику
content.on('click', '.chosen-items-to-session:not(.fandom-item) .dropdown-item', function () {
    if (getSessionKeyFromId($(this)) === 'characters') addSelectedUnit($(this), createNameItems);
    else addSelectedUnit($(this), createTitleItems);
});
// удаление выбранных элементов по клику
content.on('click', '.chosen-items-to-session .cancel-icon', function () {
    removeSelectedUnit($(this));
});



// ФЭНДОМНЫЕ СВЕДЕНИЯ
// переключение видимости фэндомной секции
content.on('change', book_type + ' input[type=radio]', function () {
    if ($(this).val() === '1') {
        let selected = $('.book-type-depend .metadata-item-selected');
        selected.empty();
        selected.addClass('hidden');
        setFandomDependVisibility(false);
        $('.book-type-depend').addClass('hidden');
        $.ajax({ // стирает все сведения о фэндоме
            type: 'post',
            url: 'index.php?r=author/create/unset-fandom'
        });
    }
    else $('.book-type-depend').removeClass('hidden');
});
// добавление выбранного фэндома по клику
content.on('click', '.fandom-item .dropdown-item', function () {
    setFandomDependVisibility(true);
    addSelectedFandomUnit($(this), createTitleItems);
});
// удаление выбранного фэндома по клику
content.on('click', '.fandom-item .remove-fandom', function (e) {
    e.preventDefault();
    let meta = $(this).closest('.metadata-item-selected-unit').attr('meta');
    removeSelectedUnit($(this), meta, function () {
        let selected = $('.metadata-fandom-selected');
        if (!selected.children().length) setFandomDependVisibility(false);
    });

});

// сохранение выбранных первоисточников
content.on('change', origins + ' input', function () {
    saveData($(this).val(), 'origins', true);
});


// добавление нового pairing-item при клике на кнопку
content.on('click', pairings, function () {
    let place = $(pairings).closest('.metadata-item').find('.metadata-item-selected');
    addNewPairingItem(place);
    place.removeClass('hidden');
});
// открытие выпадающего списка
content.on('click input', '.pairing-characters-input', function() {
    //createDropdown($(this));

    // наверное, надо сначала идти в сессию, добавлять пейринг (пустой массив с полями characters и relationship), возвращать номер элемента, который уже присваивать в id
});








