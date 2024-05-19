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
    // пейринги
    if (!checkClosest(e.target, '.dropdown-list', '.pairing-characters-input'))
        removeDropdownList($('.pairing-characters-input'));
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
content.on('click', '.chosen-items-to-session:not(.fandom-item):not(.pairings-item) .dropdown-item', function () {
    let limit = findLimit($(this));
    let limit_number = parseInt(limit.text());
    if (limit_number > 0) {
        if (getSessionKeyFromId($(this)) === 'characters') addSelectedUnit($(this), createNameItems);
        else addSelectedUnit($(this), createTitleItems);
        limit.html(--limit_number);
    }
});
// удаление выбранных элементов по клику
content.on('click', '.chosen-items-to-session:not(.pairings-item) .cancel-icon', function () {
    let limit = findLimit($(this));
    let limit_number = parseInt(limit.text());
    removeSelectedUnit($(this));
    limit.html(++limit_number);
});



// ФЭНДОМНЫЕ СВЕДЕНИЯ
// переключение видимости фэндомной секции
content.on('change', book_type + ' input[type=radio]', function () {
    if ($(this).val() === '1') {
        findLimit($(fandoms)).html(length5);
        findLimit($(characters)).html(length20);
        findLimit($(pairings)).html(length5);
        findLimit($(fandom_tags)).html(length5);

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
    let limit = findLimit($(this));
    let limit_number = parseInt(limit.text());
    if (limit_number > 0) {
        setFandomDependVisibility(true);
        addSelectedFandomUnit($(this), createTitleItems);
        limit.html(--limit_number);
    }
});
// удаление выбранного фэндома по клику
content.on('click', '.fandom-item .remove-fandom', function (e) {
    e.preventDefault();
    let meta = $(this).closest('.metadata-item-selected-unit').attr('meta');
    let limit = findLimit($(this));
    let limit_number = parseInt(limit.text());

    removeSelectedUnit($(this), meta, function () {
        let selected = $('.metadata-fandom-selected');
        if (!selected.children().length) setFandomDependVisibility(false);
    });
    limit.html(++limit_number);

});

// сохранение выбранных первоисточников
content.on('change', origins + ' input', function () {
    saveData($(this).val(), 'origins', true);
});


// добавление нового pairing-item при клике на кнопку
content.on('click', pairings, function () {
    let limit = $(this).closest('.metadata-item').find('.content-limit');
    let limit_number = parseInt(limit.text());
    if (limit_number > 0) {
        let place = $(pairings).closest('.metadata-item').find('.metadata-pairing-selected');
        addNewPairingItem(place);
        place.removeClass('hidden');
        limit.html(--limit_number);
    }
});
// открытие выпадающего списка пейринга
content.on('click input', '.pairing-characters-input', function() {
    let pairing_id = $(this).closest('.pairing-item').attr('meta');
    createDropdown($(this), createNameItems, pairing_id);
});
// добавление персонажей в пейринг
content.on('click', '.pairing-item .dropdown-item', function () {
    let id = getValueFromId($(this).attr('id'));
    let name = $(this).find('.metadata-title').text();
    let pairing = $(this).closest('.pairing-item').attr('meta');
    let unit = $(this);

    // отдельный аякс типа saveData, только для пейринга
    $.ajax({
        url: 'index.php?r=author/create/save-pairing',
        type: 'post',
        data: {data_type: 'characters', id: id, pairing: pairing},
        success: function () {
            let selected_container = unit.closest('.pairing-item').find('.metadata-item-selected');
            let to_append =
                `<div class="metadata-item-selected-unit pairing_character_item_selected_unit" meta="${id}">${name}${cancel_icon}</div>`;
            selected_container.removeClass('hidden');
            selected_container.append(to_append);
            createDropdown(unit.closest('.pairing-item').find('input[type=text]'), createNameItems, pairing);
        },
        error: function (error) {
            console.log(error);
        }
    });
});
// изменение типа взаимоотношений
content.on('change', '.pairing-item select[name=relationship]', function () {
    let id = $(this).val();
    let pairing = $(this).closest('.pairing-item').attr('meta');
    $.ajax({
        url: 'index.php?r=author/create/save-pairing',
        type: 'post',
        data: {data_type: 'relationship', id: id, pairing: pairing},
        /*success: function (response) {
            console.log(response)
        },*/
        error: function (error) {
            console.log(error);
        }
    });
});
// удаление персонажа из пейринга
content.on('click', '.pairing-item .cancel-icon', function () {
    let character_id = $(this).closest('.metadata-item-selected-unit').attr('meta');
    let pairing_id = $(this).closest('.pairing-item').attr('meta');
    let unit = $(this).closest('.metadata-item-selected-unit');

    $.ajax({
        url: 'index.php?r=author/create/delete-pairing',
        type: 'post',
        data: {remove: 'character', pairing_id: pairing_id, character_id: character_id},
        success: function () {
            let container = unit.closest('.metadata-item-selected');
            unit.remove();
            if (!container.children().length) container.addClass('hidden');
        },
        error: function (error) {
            console.log(error)
        }
    });
});
// удаление пейринга
content.on('click', '.pairing-item .delete-button', function() {
    let pairing_id = $(this).closest('.pairing-item').attr('meta');
    let item = $(this).closest('.pairing-item');
    $.ajax({
        url: 'index.php?r=author/create/delete-pairing',
        type: 'post',
        data: {remove: 'pairing', pairing_id: pairing_id},
        success: function () {
            let container = item.closest('.metadata-pairing-selected');
            item.remove();
            if (!container.children().length) container.addClass('hidden');
        },
        error: function (error) {
            console.log(error)
        }
    });
});


