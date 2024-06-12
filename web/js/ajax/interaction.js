$(document).ready(function() {
    let book_id = (new URL(document.location)).searchParams.get("id");

    // добавление оценки "Нравится"
    $('#like-interaction').click(function() {
        let button = $(this);
        $.ajax({
            type: 'post',
            url: 'http://inkwell/web/interaction/like',
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

    // добавление в прочитанное
    $('#read-interaction').click(function() {
        let button = $(this);
        $.ajax({
            type: 'post',
            url: 'http://inkwell/web/interaction/read',
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

    // добавление в "Прочитать позже"
    $('#read-later-interaction').click(function(){
        let button = $(this);
        $.ajax({
            type: 'post',
            url: 'http://inkwell/web/interaction/read-later',
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

    // добавление в избранное
    $('#favorite-book-interaction').click(function() {
        let button = $(this);
        $.ajax({
            type: 'post',
            url: 'http://inkwell/web/interaction/favorite-book',
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


    // подписаться на автора
    $('#follow-interaction').click(function () {
        let author_id = (new URL(document.location)).searchParams.get("id");
        let button = $(this);
        $.ajax({
            type: 'post',
            url: 'http://inkwell/web/interaction/follow-author',
            data: { author_id: author_id },
            success: function (response) {
                if (response.success) {
                    markButton(response.is_followed, button, 'filled-button');
                    if (response.is_followed) button.find('.button-text').text('Отписаться');
                    else button.find('.button-text').text('Подписаться');
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });


    // скачивание книги
    $('.download-interaction').click(function () {
        let format = $(this).attr('data-format');
        $.ajax({
            type: 'post',
            url: 'http://inkwell/web/interaction/download-book',
            data: {book_id: book_id, format: format},
            success: function (response) {
                //console.log(response);
                /*if (response.file) {
                    let link= document.createElement('a');
                    link.href = 'http://inkwell/web/' + response.file;
                    link.click();
                }*/
                if (response.file) {
                    let link = document.createElement('a');
                    link.href = 'http://inkwell/web/' + response.file;
                    link.download = response.file.split('/').pop(); // Извлекаем имя файла из URL
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            }
        });
    });


    // жалоба на книгу
    let complaint_dialog = $('#complaint-dialog'),
        close = complaint_dialog.find('.close-button');
    $('#complaint-interaction').click(() => { complaint_dialog[0].showModal(); });
    close.click(() => { complaint_dialog[0].close(); });
    $('#make-complaint').on('click', function () {
        let reason = $('#complaint-dialog input[type="radio"]:checked').val();
        complaint_dialog[0].close();
        $.ajax({
            url: 'http://inkwell/web/main/make-complaint',
            type: 'post',
            data: {reason: reason, book: book_id},
            success: function (resonse) {
                if (resonse.success) showMessage('Жалоба отправлена, она будет рассмотрена в ближайшее время. Благодарим за содействие', 'success');
                else showMessage('Что-то пошло не так', 'warning');
            },
            error: function (error) {
                console.log(error);
            }
        });
    });


    // награждение за грамотность
    $('#award-interaction').click(function() {
        let button = $(this);
        $.ajax({
            type: 'post',
            url: 'http://inkwell/web/interaction/award',
            data: { book_id: book_id },
            success: function(response) {
                if (response.success) {
                    markButton(response.is_awarded, button, 'filled-button');
                    if (response.is_awarded) {
                        button.find('.button-text').text('Награждено');
                        $('.is_awarded').removeClass('hidden');
                    }
                    else {
                        button.find('.button-text').text('Наградить');
                        $('.is_awarded').addClass('hidden');
                    }
                } else {
                    // Обработка ошибки
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    // публикация издательством
    $('#publish-interaction').click(function() {
        let button = $(this),
            is_published = $('.is_published');
        $.ajax({
            type: 'post',
            url: 'http://inkwell/web/interaction/publish',
            data: { book_id: book_id },
            success: function(response) {
                console.log(response)
                if (response.success) {
                    markButton(response.is_published, button, 'filled-button');
                    if (response.is_published) {
                        button.find('.button-text').text('Опубликовано');

                        is_published.html(`<div>Книга имеет печатную публикацию от издательства
                            <a class="highlight-link" href="/web/main/author?id=${response.publisher_id}">${response.publisher_name}</a>!</div>`);
                        is_published.removeClass('hidden');
                    }
                    else {
                        button.find('.button-text').text('Отметить публикацию');
                        is_published.addClass('hidden');
                    }
                } else {
                    // Обработка ошибки
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });


    // блокировка пользователя
    const block_dialog = $('#block-dialog'),
        block_close = block_dialog.find('.close-button');
    $('#block-interaction').click(() => { block_dialog[0].showModal(); });
    block_close.click(() => { block_dialog[0].close(); });

    const ban = $('#ban-user');

    $('#block-dialog input[type=radio]').on('change', function () {
        if ($('input[name=time]:checked').length && $('input[name=reason]:checked').length) ban.removeClass('disabled-button');
        else ban.addClass('disabled-button');
    });

    ban.click(function() {
        let time = $('input[name=time]:checked').val();
        let reason = $('input[name=reason]:checked').val();
        console.log(book_id, time, reason)
        $.ajax({
            url: 'http://inkwell/web/interaction/ban-user',
            type: 'post',
            data: {user: book_id, time: time, reason: reason},
            success: function (response) {
                console.log(response);
                if (response.success && response.is_banned) location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

});