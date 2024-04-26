let genres_input = $('#genres-input');

genres_input.on('input', function () {
    let input = $(this).val();
    $.ajax({
        url: 'index.php?r=author/create-book/find-genres',
        type: 'post',
        data: {input: input},
        success: function (response) {
            $('#genres-select').empty();
            $.each(response, function(key, value) {
                $('#genres-select').append(`<div class="dropdown-item" id="${key}">${value}</div>`);
            });
        },
        error: function (error) {
            console.log(error);
        }
    });
});

genres_input.click(function () {
    if ($(this).val() == '') {
        $.ajax({
            url: 'index.php?r=author/create-book/find-genres',
            type: 'post',
            success: function (response) {
                if (response) {
                    $('#genres-select').empty();
                    $.each(response, function(key, value) {
                        $('#genres-select').append(`<div class="dropdown-item" id="${key}">${value}</div>`);
                    });
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
    $('#genres-select').removeClass('hidden');
});

$(document).on('click', function(e) {
    if (!$(e.target).closest('#genres-select').length && !$(e.target).closest('#genres-input').length) {
        $('#genres-select').addClass('hidden');
    }
});

$('#genres-select').on('click', '.dropdown-item', function() {
    let id = $(this).attr('id'), title = $(this).html();
    //let hiddens = $('input[type="hidden"][value="' + id + '"]');

    let hidden = $('<input>').attr({
        type: 'hidden',
        name: 'FormCreateMain[genres][]',
        value: id
    });
    $('.selected-items').append(hidden);
    let item = $('.selected-items').append(`<div class="selected-item" genre="${id}">
                ${title}
                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon" genre="${id}">
                    <path d="m339-301.847 141-141 141 141L658.153-339l-141-141 141-141L621-658.153l-141 141-141-141L301.847-621l141 141-141 141L339-301.847Zm141.067 185.846q-74.836 0-141.204-28.42-66.369-28.42-116.182-78.21-49.814-49.791-78.247-116.129-28.433-66.337-28.433-141.173 0-75.836 28.42-141.704 28.42-65.869 78.21-115.682 49.791-49.814 116.129-78.247 66.337-28.433 141.173-28.433 75.836 0 141.704 28.42 65.869 28.42 115.682 78.21 49.814 49.791 78.247 115.629 28.433 65.837 28.433 141.673 0 74.836-28.42 141.204-28.42 66.369-78.21 116.182-49.791 49.814-115.629 78.247-65.837 28.433-141.673 28.433ZM480-168q130 0 221-91t91-221q0-130-91-221t-221-91q-130 0-221 91t-91 221q0 130 91 221t221 91Zm0-312Z" />
                </svg>
            </div>`);
});
$('.selected-items').on('click', '.to-close', function() {
    let id = $(this).attr('genre');
    $(`input[type="hidden"][value="${id}"]`).remove();
    $(`[genre=${id}]`).remove();
});