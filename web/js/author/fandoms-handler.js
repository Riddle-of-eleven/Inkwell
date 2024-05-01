let fandoms_input = $('#fandoms-input');

$('#type-radio input').on('change', function () {
    if ($(this).val() == 2) $('.fandom-section').removeClass('hidden');
    else $('.fandom-section').addClass('hidden');
});



fandoms_input.on('input', function () {
    let input = $(this).val();
    let fandoms = getSelectedFromForm('FormCreateMain', 'fandoms');
    ajaxDropDown(
        'fandoms-dropdown',
        'index.php?r=author/create-book/find-fandoms',
        {input: input, selected_fandoms: fandoms},
        $('#fandoms-select'),
        'fandom'
    );
});
fandoms_input.click(function () {
    let fandoms = getSelectedFromForm('FormCreateMain', 'fandoms');
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



$('#fandoms-select').on('click', '.dropdown-item:not(.empty-dropdown-item)', function() {
    let fandom = $(this).attr('fandom'), title = $(this).children('.metadata-title').html();
    let item = $(this);
    $.ajax({
        type: 'post',
        url: 'index.php?r=author/create-book/find-origins',
        data: {fandom: fandom},
        success: function (response) {
            //console.log(response);
            let hidden = $('<input>').attr({
                type: 'hidden',
                name: 'FormCreateFandom[fandoms][]',
                value: fandom
            });
            let selected = $('#selected-fandoms');
            if (selected.find('.fandom-first').length) {
                selected.empty();
            }
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
            to_append += `</details>`;
            selected.append(to_append);
            item.remove();
        },
        error: function (error) {
            console.log(error);
        }
    });
});
$('#selected-fandoms').on('click', '.remove-fandom', function() {
    let id = $(this).attr('fandom');
    $(`input[type="hidden"][name="FormCreateFandom[fandoms][]"][value="${id}"]`).remove();
    $(`[fandom=${id}]`).remove();

    let selected = $('#selected-fandoms');

    if (selected.length === 1)
        selected.append('<div class="tip-color fandom-first">Сначала выберите фэндом</div>');
});


$(document).on('click', function (e) {
    if (!$(e.target).closest('#fandoms-select').length && !$(e.target).closest('#fandoms-input').length && !$(e.target).closest('.dropdown-item#fandoms-dropdown').length) {
        $('#fandoms-select').addClass('hidden');
    }
});
