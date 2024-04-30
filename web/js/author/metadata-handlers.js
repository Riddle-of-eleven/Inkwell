let genres_input = $('#genres-input');
let tags_input = $('#tags-input');


// обработка добавления жанров
genres_input.on('input', function () {
    let input = $(this).val();
    let genres = getSelectedFromForm('FormCreateMain', 'genres');
    ajaxDropDown(
        'genres-dropdown',
        'index.php?r=author/create-book/find-genres',
        {input: input, selected_genres: genres},
        $('#genres-select'),
        'genre'
    );
});
genres_input.click(function () {
    let genres = getSelectedFromForm('FormCreateMain', 'genres');
    let genres_select = $('#genres-select');
    if ($(this).val() === '') // тождественно ли равно?
        ajaxDropDown(
            'genres-dropdown',
            'index.php?r=author/create-book/find-genres',
            {selected_genres: genres},
            genres_select,
            'genre'
        );
    genres_select.removeClass('hidden');
});
$('#genres-select').on('click', '.dropdown-item:not(.empty-dropdown-item)', function() {
    let genre = $(this).attr('genre'), title = $(this).children('.metadata-title').html();
    let hidden = $('<input>').attr({
        type: 'hidden',
        name: 'FormCreateMain[genres][]',
        value: genre
    });
    let selected_items = $('#genres-selected-items');
    selected_items.append(hidden);
    selected_items.append(`<div class="selected-item" genre="${genre}">
        ${title}
        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon to-close" genre="${genre}">
            <path d="m339-301.847 141-141 141 141L658.153-339l-141-141 141-141L621-658.153l-141 141-141-141L301.847-621l141 141-141 141L339-301.847Zm141.067 185.846q-74.836 0-141.204-28.42-66.369-28.42-116.182-78.21-49.814-49.791-78.247-116.129-28.433-66.337-28.433-141.173 0-75.836 28.42-141.704 28.42-65.869 78.21-115.682 49.791-49.814 116.129-78.247 66.337-28.433 141.173-28.433 75.836 0 141.704 28.42 65.869 28.42 115.682 78.21 49.814 49.791 78.247 115.629 28.433 65.837 28.433 141.673 0 74.836-28.42 141.204-28.42 66.369-78.21 116.182-49.791 49.814-115.629 78.247-65.837 28.433-141.673 28.433ZM480-168q130 0 221-91t91-221q0-130-91-221t-221-91q-130 0-221 91t-91 221q0 130 91 221t221 91Zm0-312Z" />
        </svg>
    </div>`);
    //console.log($(this));
    $(this).remove();
});
$('#genres-selected-items').on('click', '.to-close', function() {
    let id = $(this).attr('genre');
    $(`input[type="hidden"][name="FormCreateMain[genres][]"][value="${id}"]`).remove();
    $(`[genre=${id}]`).remove();
});



// обработка добавления тегов
tags_input.on('input', function () {
    let input = $(this).val();
    let tags = getSelectedFromForm('FormCreateMain', 'tags');
    ajaxDropDown(
        'tags-dropdown',
        'index.php?r=author/create-book/find-tags',
        {input: input, selected_tags: tags},
        $('#tags-select'),
        'tag'
    );
});
tags_input.click(function () {
    let tags = getSelectedFromForm('FormCreateMain', 'tags');
    let tags_select = $('#tags-select');
    if ($(this).val() === '') // ?????
        ajaxDropDown(
            'tags-dropdown',
            'index.php?r=author/create-book/find-tags',
            {selected_tags: tags},
            tags_select,
            'tag'
        );
    tags_select.removeClass('hidden');
});
$('#tags-select').on('click', '.dropdown-item:not(.empty-dropdown-item)', function() {
    let tag = $(this).attr('tag'), title = $(this).children('.metadata-title').html();
    let hidden = $('<input>').attr({
        type: 'hidden',
        name: 'FormCreateMain[tags][]',
        value: tag
    });
    let selected_items = $('#tags-selected-items');
    selected_items.append(hidden);
    selected_items.append(`<div class="selected-item" tag="${tag}">
        ${title}
        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon to-close" tag="${tag}">
            <path d="m339-301.847 141-141 141 141L658.153-339l-141-141 141-141L621-658.153l-141 141-141-141L301.847-621l141 141-141 141L339-301.847Zm141.067 185.846q-74.836 0-141.204-28.42-66.369-28.42-116.182-78.21-49.814-49.791-78.247-116.129-28.433-66.337-28.433-141.173 0-75.836 28.42-141.704 28.42-65.869 78.21-115.682 49.791-49.814 116.129-78.247 66.337-28.433 141.173-28.433 75.836 0 141.704 28.42 65.869 28.42 115.682 78.21 49.814 49.791 78.247 115.629 28.433 65.837 28.433 141.673 0 74.836-28.42 141.204-28.42 66.369-78.21 116.182-49.791 49.814-115.629 78.247-65.837 28.433-141.673 28.433ZM480-168q130 0 221-91t91-221q0-130-91-221t-221-91q-130 0-221 91t-91 221q0 130 91 221t221 91Zm0-312Z" />
        </svg>
    </div>`);
    //console.log($(this));
    $(this).remove();
});
$('#tags-selected-items').on('click', '.to-close', function() {
    let id = $(this).attr('tag');
    $(`input[type="hidden"][name="FormCreateMain[tags][]"][value="${id}"]`).remove();
    $(`[tag=${id}]`).remove();
});



// закрытие при щелчке вне областей ввода
$(document).on('click', function(e) {
    if (!$(e.target).closest('#genres-select').length && !$(e.target).closest('#genres-input').length && !$(e.target).closest('.dropdown-item#genres-dropdown').length && !$(e.target).closest('.genre-type').length) {
        $('#genres-select').addClass('hidden');
    }
    if (!$(e.target).closest('#tags-select').length && !$(e.target).closest('#tags-input').length && !$(e.target).closest('.dropdown-item#tags-dropdown').length && !$(e.target).closest('.tag-type').length) {
        $('#tags-select').addClass('hidden');
    }
});



// жанры по категориям
$('.genre-type').click(function () {
    let type = $(this).attr('genre_type');
    let genres = getSelectedFromForm('FormCreateMain', 'genres');
    let genres_select = $('#genres-select');
    ajaxDropDown(
        'genres-dropdown',
        'index.php?r=author/create-book/find-genres',
        {selected_genres: genres, genre_type: type},
        genres_select,
        'genre'
    );
    genres_select.removeClass('hidden');
})



// теги по категориям
$('.tag-type').click(function () {
    let type = $(this).attr('tag_type');
    let tags = getSelectedFromForm('FormCreateMain', 'tags');
    let tags_select = $('#tags-select');
    ajaxDropDown(
        'tags_dropdown',
        'index.php?r=author/create-book/find-tags',
        {selected_tags: tags, tag_type: type},
        tags_select,
        'tag'
    );
    tags_select.removeClass('hidden');
})



// вспомогательные функции
function getSelectedFromForm(form, field) {
    let selected = $(`input[type="hidden"][name="${form}[${field}][]"]`);
    let selected_id = [];
    $.each(selected, function (key, value) {
        selected_id[key] = $(value).attr('value');
    })
    return selected_id;
}

function ajaxDropDown(id, url, data, select, type_name) {
    // select это genres-select или tag-select
    $.ajax({
        url: url,
        type: 'post',
        data: data,
        success: function (response) {
            select.empty();
            if (Object.keys(response).length !== 0) // опять тождественно равно????
                $.each(response, function(key, value) {
                    select.append(`<div class="dropdown-item" id="${id}" ${type_name}="${value.id}">
                        <div class="metadata-title">${value.title}</div>
                        <div class="metadata-description tip">${value.description}</div>
                    </div>`);
                });
            else select.append('<div class="tip-color dropdown-item empty-dropdown-item">Ничего не найдено</div>');
        },
        error: function (error) {
            console.log(error);
        }
    });
}