let modal = $('.to-collection');
let open = $('#collection-interaction');
let close = $('.close-button');

open.click(function () {
    modal[0].showModal();
    $('#add-modal').addClass('hidden');
    $('#regular-modal').removeClass('hidden');
    $.ajax({
        type: 'post',
        url: 'index.php?r=interaction/get-collections',
        success: function(response) {
            if (response.data) {
                let content = '';
                response.data.forEach(function(element) {
                    content += `<button class="ui button collection-item block" id="collection-${element.collection.id}">
                                    <div>${element.collection.title}</div>
                                    <div class="tip-color">${element.count}</div>
                                </button>`;
                });
                $('.collections-container').html(content);
            }
        },
        error: function(error) {

        }
    });
});
close.click(() => { modal[0].close(); });

$('.collections-container').on('click', '.collection-item', function() {
    $.ajax({
        type: 'post',
        url: 'index.php?r=interaction/add-to-collection',
        data: {
            book_id: (new URL(document.location)).searchParams.get("id"),
            collection_id: $(this).attr('id')
        },
        success: function(response) {
            if (response.success) {
                modal[0].close(); modal.removeClass('showed');
                if (response.is_already) showMessage('Книга уже добавлена в эту подборку', 'warning');
                else {
                    if (response.is_added) showMessage('Книга успешно добавлена в подборку', 'success');
                    else showMessage('Что-то пошло не так, кажется, книга не была добавлена в подборку', 'error');
                }
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
});

$('.collection-create').click(function(e) {
    let add = $('#add-modal');
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: 'index.php?r=interaction/create-collection-and-add',
        data: {book_id: (new URL(document.location)).searchParams.get("id") },
        success: function(response) {
            $('#regular-modal').addClass('hidden');
            add.removeClass('hidden');
            add.html(response);
        }
    });
});