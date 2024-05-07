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



// создание выпадающего списка (element – это input, callback – функция генерации правильного содержимого)
function createDropdown(element, callback, type = null) {
    let meta_type = getMetaNameFromId(element.attr('id'));
    $.ajax({
        type: 'post',
        url: 'index.php?r=author/create/find-meta',
        data: {
            input: element.val(),
            meta_type: meta_type,
            type: type
        },
        success: function (response) {
            let container = element.closest('.field-with-dropdown');
            let neighbor = getNeighborDropdown(element);
            // это проверка на существование и подгонка положения
            if (neighbor.length) {
                //console.log(response);
                neighbor.empty();
                neighbor.append(callback(response, meta_type));
                let bottom = bottomOffset(neighbor.closest('.field-with-dropdown').find('.field'));
                if (neighbor.outerHeight() > (bottom + 10)) neighbor.css('top', -(neighbor.outerHeight() + 4));
                else neighbor.css('top', (container.find('.field').outerHeight() + 4));
            }
            // это добавление, если его не было
            else {
                let list = $(`<div class="dropdown-list block"></div>`);
                list.append(callback(response, meta_type));
                container.append(list);
                if (bottomOffset(list) < 10) list.css('top', -(list.outerHeight() + 4));
                else list.css('top', (container.find('.field').outerHeight() + 4));
            }
        },
        error: function (error) {
            console.log(error);
            //return false;
        }
    });
    //return true;
}
// это создание пунктов выпадающего списка по лекалу названия, а не имени (как у персонажей, например)
function createTitleItems(response, meta_type) {
    let to_append = '';
    if (Object.keys(response).length !== 0) // опять тождественно равно????
        $.each(response, function (key, value) {
            to_append += `<div class="dropdown-item" id="step-meta-${meta_type}-${value.id}">
                            <div class="metadata-title">${value.title}</div>`;
            if (value.description) to_append += `<div class="metadata-description tip">${value.description}</div>`;
            to_append += `</div>`;
        });
    else to_append = '<div class="tip-color dropdown-item empty-dropdown-item">Ничего не найдено</div>';
    return to_append;
}
function removeDropdownList(field) {
    field.closest('.field-with-dropdown').find('.dropdown-list').remove();
}


// добавление выбранных метаданных
function addSelectedUnit(unit, callback) {
    let id = getValueFromId(unit.attr('id'));
    let key = getSessionKeyFromId(unit);
    saveData(id, key, true, function(){
        // эта функция нужна для того, чтобы saveData() точно выполнилась раньше createDropdown()
        let selected_container = unit.closest('.metadata-item').find('.metadata-item-selected');
        let to_append = `<div class="metadata-item-selected-unit" meta="${id}">${unit.find('.metadata-title').text()}${cancel_icon}</div>`;
        selected_container.removeClass('hidden');
        selected_container.append(to_append);
        createDropdown(unit.closest('.metadata-item').find('input'), callback);
    });
}
// удаление выбранных метаданных
function removeSelectedUnit(button) {
    let unit = button.closest('.metadata-item-selected-unit');
    let input = button.closest('.metadata-item').find('input');

    let key = getSessionKeyFromId(input);
    let value = unit.attr('meta');

    saveData(value, key, true);
    let container = button.closest('.metadata-item-selected');
    unit.remove();
    if (!container.children().length) container.addClass('hidden');
}






// подсчитывает и устанавливает количество символов около ввода
function countSymbolsFromField(field, total) {
    let count = field.val().length;
    let place = field.closest('.metadata-item').find('.content-limit');
    place.html(total - count);
}

// сохраняет вводимые данные в сессию (последний параметр – это элемент, который требуется удалить)
function saveData(data, session_key, is_array = false, callback = null) {
    $.ajax({
        url: 'index.php?r=author/create/save-data',
        type: 'post',
        data: {data: data, session_key: session_key, is_array: is_array},
        success: function () {
            //console.log(response)
            if (typeof callback === 'function') {
                callback();
            }
        }
    });
}


// получает имя сессионного ключа из id (по элементу)
function getSessionKeyFromId(element) {
    let id = element.attr('id').split('-');
    if (parseInt(id[id.length - 1])) return id[id.length - 2];
    return id[id.length - 1];
}
// преобразовывает вид строки id просто в имя id
function getNameFromId(id) {
    if (id) return id.slice(1);
    return false;
}
// то же самое, но получает имя типа метаданных
function getMetaNameFromId(id) {
    let words = id.split("-");
    return words[words.length - 1];
}
// получает числового представление id (если такое вообще есть)
function getValueFromId(id) {
    return parseInt(id.match(/\d+/)[0]);
}


// поиск dropdown, соответствующего input
function getNeighborDropdown(input) {
    return input.closest('.field-with-dropdown').find('.dropdown-list');
}
// проверка на соседей элемента для закрытия
function checkClosest(target) {
    let flag = false;
    for (let i = 1; i < arguments.length; i++) {
        if ($(target).closest(arguments[i]).length) {
            flag = true; break;
        }
    }
    return flag;
}

// считает расстояние от нижнего края элемента до конца окна
function bottomOffset(element) {
    return $(window).height() - element[0].getBoundingClientRect().bottom;
}