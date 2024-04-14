$(document).ready(function() {
    let book_id = (new URL(document.location)).searchParams.get("id");

    // лайк
    $('#like-interaction').click(function() {
        let button = $(this);
        $.ajax({
            type: 'post',
            url: 'index.php?r=interaction/like',
            data: { book_id: book_id },
            success: function(response) {
                if (response.success) {
                    markButton(response.is_liked, button, 'filled-button');
                } else {
                    // Обработка ошибки
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    // прочитано
    $('#read-interaction').click(function() {
        let button = $(this);
        $.ajax({
            type: 'post',
            url: 'index.php?r=interaction/read',
            data: { book_id: book_id },
            success: function (response) {
                if (response.success) {
                    let read_later = $('#read-later-interaction');
                    markButton(response.is_read, button, 'filled-button');
                    markButton(response.is_read, read_later, 'inactive-button');

                    if (response.is_read) read_later.prop('disabled', true);
                    else read_later.prop('disabled', false);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // прочитать позже
    $('#read-later-interaction').click(function(){
        let button = $(this);
        $.ajax({
            type: 'post',
            url: 'index.php?r=interaction/read-later',
            data: { book_id: book_id },
            success: function (response) {
                if (response.success) {
                    let read = $('#read-interaction');
                    markButton(response.is_read_later, button, 'filled-button');
                    markButton(response.is_read_later, read, 'inactive-button');

                    if (response.is_read_later) read.prop('disabled', true);
                    else read.prop('disabled', false);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // избранное
    $('#favorite-book-interaction').click(function() {
        let button = $(this);
        $.ajax({
            type: 'post',
            url: 'index.php?r=interaction/favorite-book',
            data: { book_id: book_id },
            success: function (response) {
                if (response.success) {
                    markButton(response.is_favorite, button, 'filled-button');
                    if (response.is_favorite) button.find('.button-text').text('В избранном');
                    else button.find('.button-text').text('Добавить в избранное');
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

});