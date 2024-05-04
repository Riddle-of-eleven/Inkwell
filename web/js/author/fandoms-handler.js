let fandoms_input = $('#fandoms-input');
let characters_container = $('.characters-container');
let pairings_container = $('.pairings-container');
let fandoms_select = $('#fandoms-select');
let selected_fandoms = $('#selected-fandoms');

let fandom_first_str = '<div class="tip-color fandom-first">Сначала выберите фэндом</div>';


// отображение и скрытие всего, что касается фэндомных сведений
$('#type-radio input').on('change', function () {
    // тождественно равно?????
    if ($(this).val() === 2) $('.fandom-section').removeClass('hidden');
    else $('.fandom-section').addClass('hidden');
});


// создание выпадающего списка при клике по полю и при вводе текста
fandoms_input.on('input', function () {
    let input = $(this).val();
    let fandoms = getSelectedFromForm('FormCreateFandom', 'fandoms');
    ajaxDropDown(
        'fandoms-dropdown',
        'index.php?r=author/create-book/find-fandoms',
        {input: input, selected_fandoms: fandoms},
        $('#fandoms-select'),
        'fandom'
    );
});
fandoms_input.click(function () {
    let fandoms = getSelectedFromForm('FormCreateFandom', 'fandoms');
    //console.log(fandoms)
    let fandoms_select = $('#fandoms-select');
    if ($(this).val() === '') // ?????
        ajaxDropDown(
            'fandoms-dropdown',
            'index.php?r=author/create-book/find-fandoms',
            {selected_fandoms: fandoms},
            fandoms_select,
            'fandom'
        );
    fandoms_select.removeClass('hidden');
});

// действия при выборе конкретного фэндома
fandoms_select.on('click', '.dropdown-item:not(.empty-dropdown-item)', function() {
    let fandom = $(this).attr('fandom'), title = $(this).children('.metadata-title').html(), item = $(this);
    createOriginSection(fandom, title, item); // формирование секции первоисточников (в том же месте, что в фэндомы)
    createCharacterSection(); // формирование секции персонажей
    createPairingSection(); // формирование секции пейрингов (кнопка добавления)
    /*console.log(fandoms_select);
    if (fandoms_select.is(':empty')) fandoms_select.append('<div class="tip-color dropdown-item empty-dropdown-item">Ничего не найдено</div>');*/
});

// действия при удалении выбранного фэндома
selected_fandoms.on('click', '.remove-fandom', function() {
    let id = $(this).attr('fandom');
    $(`input[type="hidden"][name="FormCreateFandom[fandoms][]"][value="${id}"]`).remove();
    $(`[fandom=${id}]`).remove();

    if (selected_fandoms.is(':empty')) {
        characters_container.empty(); characters_container.append(fandom_first_str);
        pairings_container.empty(); pairings_container.append(fandom_first_str);
    }
});


// сокрытие выпадающих списков при клике вне их
$(document).on('click', function (e) {
    if (!$(e.target).closest('#fandoms-select').length && !$(e.target).closest('#fandoms-input').length /*&& !$(e.target).closest('.dropdown-item#fandoms-dropdown').length*/)
        $('#fandoms-select').addClass('hidden');
    if (!$(e.target).closest('#characters-select').length && !$(e.target).closest('#characters-input').length && !$(e.target).closest('.dropdown-item#characters-dropdown').length)
        $('#characters-select').addClass('hidden');
});


// функция создания секции первоисточников
function createOriginSection(fandom, title, item) {
    $.ajax({
        type: 'post',
        url: 'index.php?r=author/create-book/find-origins',
        data: {fandom: fandom},
        success: function (response) {
            let hidden = $('<input>').attr({
                type: 'hidden',
                name: 'FormCreateFandom[fandoms][]',
                value: fandom
            });
            let selected = $('#selected-fandoms');
            if (selected.find('.fandom-first').length)
                selected.empty();
            selected.append(hidden);
            let to_append = `<details fandom="${fandom}">
                <summary class="select-header block">
                    <div class="select-header-expand">
                        <div class="expand-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon">
                                <path d="M480-346.463 253.847-572.615 291-609.768l189 189 189-189 37.153 37.153L480-346.463Z"/>
                            </svg>
                        </div>
                        ${title}
                    </div>
                    <div class="ui button small-button danger-accent-button remove-fandom" fandom="${fandom}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon">
                            <path d="M324.309-164.001q-26.623 0-45.465-18.843-18.843-18.842-18.843-45.465V-696h-48v-51.999H384v-43.384h192v43.384h171.999V-696h-48v467.257q0 27.742-18.65 46.242-18.65 18.5-45.658 18.5H324.309ZM648-696H312v467.691q0 5.385 3.462 8.847 3.462 3.462 8.847 3.462h311.382q4.616 0 8.463-3.846 3.846-3.847 3.846-8.463V-696ZM400.155-288h51.999v-336h-51.999v336Zm107.691 0h51.999v-336h-51.999v336ZM312-696V-216v-480Z"/>
                        </svg>
                    </div>
                </summary>`;
            if (Object.keys(response).length !== 0) {
                to_append += `<div class="select-content">
                    <div class="select-column-title">Название</div>
                    <div class="select-column-title">Тип медиа</div>
                    <div class="select-column-title">Год создания</div>
                    <div class="select-column-title">Создатель</div>`;
                $.each(response, function(key, value) {
                    to_append += `<div origin="${value.origin.id}">
                            <input type="checkbox" name="FormCreateFandom[origins][]" id="origin-${value.origin.id}" value="${value.origin.id}">
                            <label for="origin-${value.origin.id}">${value.origin.title}</label>
                        </div>
                        <div>${value.media}</div>
                        <div>${value.origin.release_date}</div>
                        <div>${value.origin.creator}</div>`;
                });
                to_append += `</div>`;
            }
            else to_append += `<div class="select-content tip-color">У этого фэндома нет первоисточников</div>`;
            to_append += `</details>`;
            selected.append(to_append);
            item.remove();
        },
        error: function (error) {
            console.log(error);
        }
    });
}


// функция для создания секции персонажей
function createCharacterSection() {
    characters_container.empty();
    characters_container.append(`<div class="field-with-dropdown">
        <div class="ui field">
            <input type="text" id="characters-input" name="characters-input" placeholder="Введите первые несколько символов...">
        </div>
        <div class="dropdown-list block hidden" id="characters-select"></div>
    </div>`);
}
// добавление персонажей на ввод и клик по полю
characters_container.on('input', '#characters-input', function() {
    let input = $(this).val();
    let characters = getSelectedFromForm('FormCreateFandom', 'characters');
    let fandoms = getSelectedFromForm('FormCreateFandom', 'fandoms');
    ajaxCharactersDropDown(
        'characters-dropdown',
        'index.php?r=author/create-book/find-characters',
        {input: input, selected_fandoms: fandoms, selected_characters: characters},
        $('#characters-select')
    );
});
characters_container.on('click', '#characters-input', function() {
    let characters = getSelectedFromForm('FormCreateFandom', 'characters');
    let fandoms = getSelectedFromForm('FormCreateFandom', 'fandoms');
    let characters_select = $('#characters-select');
    if ($(this).val() === '') // ?????
        ajaxCharactersDropDown(
            'characters-dropdown',
            'index.php?r=author/create-book/find-characters',
            {selected_fandoms: fandoms, selected_characters: characters},
            characters_select
        );
    characters_select.removeClass('hidden');
});
// добавление персонажа при клике на пункт выпадающего списка
characters_container.on('click', '.dropdown-item:not(.empty-dropdown-item)', function() {
    let character = $(this).attr('character'), title = $(this).children('.metadata-title').html();
    let hidden = $('<input>').attr({
        type: 'hidden',
        name: 'FormCreateFandom[characters][]',
        value: character
    });
    let selected_items = $('#characters-selected-items');
    selected_items.append(hidden);
    selected_items.append(`<div class="selected-item" character="${character}">
        ${title}
        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon to-close" character="${character}">
            <path d="m339-301.847 141-141 141 141L658.153-339l-141-141 141-141L621-658.153l-141 141-141-141L301.847-621l141 141-141 141L339-301.847Zm141.067 185.846q-74.836 0-141.204-28.42-66.369-28.42-116.182-78.21-49.814-49.791-78.247-116.129-28.433-66.337-28.433-141.173 0-75.836 28.42-141.704 28.42-65.869 78.21-115.682 49.791-49.814 116.129-78.247 66.337-28.433 141.173-28.433 75.836 0 141.704 28.42 65.869 28.42 115.682 78.21 49.814 49.791 78.247 115.629 28.433 65.837 28.433 141.673 0 74.836-28.42 141.204-28.42 66.369-78.21 116.182-49.791 49.814-115.629 78.247-65.837 28.433-141.673 28.433ZM480-168q130 0 221-91t91-221q0-130-91-221t-221-91q-130 0-221 91t-91 221q0 130 91 221t221 91Zm0-312Z" />
        </svg>
    </div>`);
    $(this).remove();
});

// удаление выбранного персонажа
$('#characters-selected-items').on('click', '.to-close', function() {
    let id = $(this).attr('character');
    console.log(id)
    $(`input[type="hidden"][name="FormCreateFandom[characters][]"][value="${id}"]`).remove();
    $(`[character=${id}]`).remove();
});



// функция создания секции пейрингов
function createPairingSection() {
    let container = pairings_container;
    container.empty();
    container.append(`<div class="ui button icon-button" id="add-pairing-button">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.88886 5.66294C6.21776 5.8827 6.60444 6 7 6C7.53026 5.99944 8.03865 5.78855 8.4136 5.4136C8.78855 5.03865 8.99944 4.53026 9 4C9 3.60444 8.8827 3.21776 8.66294 2.88886C8.44318 2.55996 8.13082 2.30362 7.76537 2.15224C7.39992 2.00087 6.99778 1.96126 6.60982 2.03843C6.22186 2.1156 5.86549 2.30608 5.58579 2.58579C5.30608 2.86549 5.1156 3.22186 5.03843 3.60982C4.96126 3.99778 5.00087 4.39991 5.15224 4.76537C5.30362 5.13082 5.55996 5.44318 5.88886 5.66294ZM6.44443 3.16853C6.60888 3.05865 6.80222 3 7 3C7.26512 3.00031 7.5193 3.10576 7.70677 3.29323C7.89424 3.4807 7.9997 3.73488 8 4C8 4.19778 7.94135 4.39112 7.83147 4.55557C7.72159 4.72002 7.56541 4.84819 7.38268 4.92388C7.19996 4.99957 6.99889 5.01937 6.80491 4.98079C6.61093 4.9422 6.43275 4.84696 6.29289 4.70711C6.15304 4.56725 6.0578 4.38907 6.01922 4.19509C5.98063 4.00111 6.00043 3.80004 6.07612 3.61732C6.15181 3.43459 6.27998 3.27841 6.44443 3.16853Z" />
            <path d="M14.5 7H5.5C5.10231 7.00044 4.72103 7.15861 4.43982 7.43982C4.15861 7.72103 4.00044 8.10231 4 8.5V11.5C4.0003 11.7651 4.10576 12.0193 4.29323 12.2068C4.4807 12.3942 4.73488 12.4997 5 12.5V16C5.0003 16.2651 5.10576 16.5193 5.29323 16.7068C5.4807 16.8942 5.73488 16.9997 6 17H8C8.26512 16.9997 8.5193 16.8942 8.70677 16.7068C8.89424 16.5193 8.9997 16.2651 9 16V10H8V16H6V11.5H5V8.5C5.00012 8.36743 5.05284 8.24032 5.14658 8.14658C5.24032 8.05284 5.36743 8.00012 5.5 8H14.5C14.6326 8.00012 14.7597 8.05284 14.8534 8.14658C14.9472 8.24032 14.9999 8.36743 15 8.5V11.5H14V13.0295C14.2797 13.0084 14.6076 13.0024 15 13.0007V12.5C15.2651 12.4997 15.5193 12.3942 15.7068 12.2068C15.8942 12.0193 15.9997 11.7651 16 11.5V8.5C15.9996 8.10231 15.8414 7.72103 15.5602 7.43982C15.279 7.15861 14.8977 7.00044 14.5 7Z"/>
            <path d="M12.0007 16C12 16.1561 12 16.3225 12 16.5C12 16.6775 12 16.8439 12.0007 17C11.7356 16.9997 11.4807 16.8942 11.2932 16.7068C11.1058 16.5193 11.0003 16.2651 11 16V10H12L12.0007 16Z" />
            <path fill-rule="evenodd" clip-rule="evenodd" d="M13 6C12.6044 6 12.2178 5.8827 11.8889 5.66294C11.56 5.44318 11.3036 5.13082 11.1522 4.76537C11.0009 4.39991 10.9613 3.99778 11.0384 3.60982C11.1156 3.22186 11.3061 2.86549 11.5858 2.58579C11.8655 2.30608 12.2219 2.1156 12.6098 2.03843C12.9978 1.96126 13.3999 2.00087 13.7654 2.15224C14.1308 2.30362 14.4432 2.55996 14.6629 2.88886C14.8827 3.21776 15 3.60444 15 4C14.9994 4.53026 14.7886 5.03865 14.4136 5.4136C14.0386 5.78855 13.5303 5.99944 13 6ZM13 3C12.8022 3 12.6089 3.05865 12.4444 3.16853C12.28 3.27841 12.1518 3.43459 12.0761 3.61732C12.0004 3.80004 11.9806 4.00111 12.0192 4.19509C12.0578 4.38907 12.153 4.56725 12.2929 4.70711C12.4327 4.84696 12.6109 4.9422 12.8049 4.98079C12.9989 5.01937 13.2 4.99957 13.3827 4.92388C13.5654 4.84819 13.7216 4.72002 13.8315 4.55557C13.9414 4.39112 14 4.19778 14 4C13.9997 3.73488 13.8942 3.4807 13.7068 3.29323C13.5193 3.10576 13.2651 3.00031 13 3Z" />
            <path d="M15.5 19.0833V17.5833H14V16.5H15.5V15H16.5833V16.5H18.0833V17.5833H16.5833V19.0833H15.5Z" />
        </svg>
        Добавить пейринг
    </div>`);
}

// добавление области для нового пейринга при нажатии на клопку
pairings_container.on('click', '#add-pairing-button', function () {
    pairings_container.prepend(`<div>
        <div class="pairing-item block">
            <div class="field-with-dropdown pairing-choice">
                <div class="selected-items pairing-selected-items"></div>
                <div class="ui field"><input type="text" name="pairing-characters-input" id="pairing-characters-input" placeholder="Введите первые несолько символов..."></div>
                <div class="dropdown-list block hidden" id="pairing-characters-select"></div>
            </div>
            <div class="ui button small-button danger-accent-button">
                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon">
                    <path d="M324.309-164.001q-26.623 0-45.465-18.843-18.843-18.842-18.843-45.465V-696h-48v-51.999H384v-43.384h192v43.384h171.999V-696h-48v467.257q0 27.742-18.65 46.242-18.65 18.5-45.658 18.5H324.309ZM648-696H312v467.691q0 5.385 3.462 8.847 3.462 3.462 8.847 3.462h311.382q4.616 0 8.463-3.846 3.846-3.847 3.846-8.463V-696ZM400.155-288h51.999v-336h-51.999v336Zm107.691 0h51.999v-336h-51.999v336ZM312-696V-216v-480Z"/>
                </svg>
            </div>
        </div>
    </div>`);
});

// отображение выпадающего списка персонажей при нажатии и вводе
pairings_container.on('input', '#pairing-characters-input', function () {
    showCharactersDropdown($(this), $('#pairing-characters-select'));
});
pairings_container.on('click', '#pairing-characters-input', function () {
    showCharactersDropdown($(this), $('#pairing-characters-select'));
});


function showCharactersDropdown(element, select) {
    let data = {
        selected_fandoms: getSelectedFromForm('FormCreateFandom', 'fandoms'),
        selected_characters: getSelectedFromForm('FormCreateFandom', 'characters'),};
    data.input = element.val();
    ajaxCharactersDropDown('characters-dropdown', 'index.php?r=author/create-book/find-characters', data, select);
    select.removeClass('hidden');
}



/////
