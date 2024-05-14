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
}



// создание выпадающего списка (element – это input, callback – функция генерации правильного содержимого)
function createDropdown(element, callback, type = null) {
    //let meta_type = getMetaNameFromId(element.attr('id'));
    let meta_type = getSessionKeyFromId(element);
    //console.log(meta_type)
    $.ajax({
        type: 'post',
        url: 'index.php?r=author/create/find-meta',
        data: {
            input: element.val(),
            meta_type: meta_type,
            type: type // в случае пейринга сюда передаётся его id
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
// а это пункты по лекалу имени персонажа
function createNameItems(response, meta_type) {
    let to_append = '';
    if (Object.keys(response).length !== 0) {// опять тождественно равно????
        $.each(response, function (key, value) {
            to_append += `<div class="dropdown-item" id="step-meta-${meta_type}-${value.character.id}">
                            <div class="metadata-title">${value.character.full_name}</div>`;
            if (value.fandom) to_append += `<div class="metadata-description tip">${value.fandom.title}</div>`;
            to_append += `</div>`;
        });
    }
    else to_append = '<div class="tip-color dropdown-item empty-dropdown-item">Ничего не найдено</div>';
    return to_append;
}
// скрытие выпадающего списка
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
// удаление выбранных метаданных (check_for_origins нужен для удаления сопутствующих первоисточников у фэндома)
function removeSelectedUnit(button, remove_depend = false, next = null) {
    let unit = button.closest('.metadata-item-selected-unit');
    let input = button.closest('.metadata-item').find('input');

    let key = getSessionKeyFromId(input);
    let value = unit.attr('meta');

    saveData(value, key, true);
    if (remove_depend) {
        $.ajax({
            type: 'post',
            url: 'index.php?r=author/create/remove-fandom-depend',
            data: {fandom_id: remove_depend},
            success: function (response) {
                //console.log(response.characters)
                if (response.characters) {
                    let container = $(characters).closest('.metadata-item');
                    $.each(response.characters, function (key, value) {
                        container.find(`.metadata-item-selected-unit[meta=${value}]`).remove();
                    });
                }
                if (response.fandom_tags) {
                    let container = $(fandom_tags).closest('.metadata-item');
                    $.each(response.fandom_tags, function (key, value) {
                        container.find(`.metadata-item-selected-unit[meta=${value}]`).remove();
                    });
                }
                if (response.pairings) {
                    let container = $(pairings).closest('.metadata-item');
                    $.each(response.pairings, function (key, value) {
                        container.find(`.pairing-item[meta=${value}]`).remove();
                    });
                }
                continueActions() // вот это нужно для правильной последовательности действий
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
    else continueActions();

    function continueActions() {
        let container = button.closest('.metadata-item-selected');
        unit.remove();
        if (!container.children().length) container.addClass('hidden');
        if (next) next(); // и вот это тоже, блин
    }
}

// добавление выбранного, но конкретно для фэндомов
function addSelectedFandomUnit(unit, callback) {
    let id = getValueFromId(unit.attr('id'));
    let key = getSessionKeyFromId(unit);

    saveData(id, key, true, function () {
        let selected_container = unit.closest('.metadata-item').find('.metadata-item-selected');
        let to_append =
            `<details class="metadata-item-selected-unit metadata-fandom-selected-unit" meta="${id}">
                <summary class="block select-header">
                    <div class="select-header-expand"><div class="expand-icon">${expand_icon}</div>${unit.find('.metadata-title').text()}</div>
                    <div class="ui button small-button danger-accent-button remove-fandom">${delete_icon}</div>
                </summary>
                <div class="inner-details-field"></div>
            </details>`;
        selected_container.removeClass('hidden');
        selected_container.append(to_append);

        $.ajax({
            type: 'post',
            url: 'index.php?r=author/create/find-meta',
            data: {meta_type: 'origins', fandom_id: id},
            success: function (response) {
                //console.log(response)
                let details = $(`.metadata-fandom-selected-unit[meta=${id}] .inner-details-field`);
                let to_append = '';
                if (Object.keys(response).length !== 0) { // опять тождественно равно????
                    to_append += `<div class="inner-details-choice self-table">
                            <div></div>
                            <div>Название</div>
                            <div>Тип медиа</div>
                            <div>Год создания</div>
                            <div>Создатель</div>
                        </div>`;
                    $.each(response, function (key, value) {
                        to_append +=
                            `<label class="inner-details-choice">
                                <input type='checkbox' name='origins' id="origin-${value.origin.id}" value='${value.origin.id}' ${value.checked}>
                                <span>
                                    <div>${value.origin.title}</div>
                                    <div>${value.media}</div>
                                    <div>${value.origin.release_date}</div>
                                    <div>${value.origin.creator}</div>
                                </span>
                            </label>`;
                    });
                }
                else to_append = `<div class="empty-origin tip-color">У этого фэндома нет первоисточников</div>`;

                details.append(to_append);
            },
            error: function (error) {
                console.log(error);
            }
        });

        createDropdown(unit.closest('.metadata-item').find('input'), callback);
    });
}


function addNewPairingItem(place) {
    $.ajax({
        type: 'post',
        url: 'index.php?r=author/create/manage-pairing',
        data: {action: 'create'},
        success: function (response) {
            //console.log(response);
            if (response) {
                let to_append =
                    `<div class="pairing-item block" meta="${response.id}">
                        <div class="pairing-choice">
                            <div class="field-with-dropdown">
                                <div class="ui field"><input type="text" name="pairing-characters-input" class="pairing-characters-input" id="step-meta-main-pairing_characters-${response.id}" placeholder="Введите первые несколько символов..."></div>
                            </div>
                            <div class="metadata-item-selected pairing-selected-items hidden"></div>
                        </div>
                        <div class="ui field field-select">
                            <select name="relationship" id="relationship-${response.id}">`;
                if (response.relationships)
                    $.each(response.relationships, function (key, value) {
                        let selected = '';
                        if (response.this_relationship === value.id) selected = 'selected';
                        to_append += `<option value="${value.id}" ${selected}>${value.title}</option>`;
                    });
                to_append += `</select></div>`;
                to_append += `<div class="ui button small-button delete-button danger-accent-button">${delete_icon}</div>
                    </div>`;
                place.append(to_append);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });

}



// подсчитывает и устанавливает количество символов около ввода
function countSymbolsFromField(field, total) {
    let count = field.val().length;
    let place = field.closest('.metadata-item').find('.content-limit');
    place.html(total - count);
}
//
function countSelectedChildren(element, selected_class, total) {
    let selected = element.closest('.chosen-items-to-session').find(selected_class);
    let count = selected.children().length;
    let place = element.closest('.chosen-items-to-session').find('.content-limit');
    place.html(total - count);
}
//
function findLimit(element) {
    return element.closest('.metadata-item').find('.content-limit');
}
//
function findClosest(element, id) {
    return element.closest('.metadata-item').find(id)/*.length !== 0*/;
}

// сохраняет вводимые данные в сессию
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
        },
        error: function (error) {
            console.log(error);
        }
    });
}


// получает имя сессионного ключа из id (по элементу)
function getSessionKeyFromId(element) {
    let id = element.attr('id').split('-');
    if (Number.isInteger(parseInt(id[id.length - 1]))) return id[id.length - 2];
    return id[id.length - 1];
}
// преобразовывает вид строки id просто в имя id
function getNameFromId(id) {
    if (id) return id.slice(1);
    return false;
}
// то же самое, но получает имя типа метаданных
/*function getMetaNameFromId(id) {
    let words = id.split("-");
    return words[words.length - 1];
}*/
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

// задаёт видимость полям, зависимым от фэндома
function setFandomDependVisibility(visibility) {
    if (visibility) {
        $('.fandom-depend').removeClass('hidden');
        $('.fandom-depend-replacement').addClass('hidden');
    }
    else {
        $('.fandom-depend').addClass('hidden');
        $('.fandom-depend-replacement').removeClass('hidden');
    }
}