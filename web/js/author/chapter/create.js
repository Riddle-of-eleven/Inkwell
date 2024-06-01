$('#create-chapter-type input[type=radio]').on('change', function() {
    let value = $(this).val();
    saveChapterData(value, 'type');
    if (value === 'chapter') $('#chapter-depend').removeClass('hidden');
    else $('#chapter-depend').addClass('hidden');
});

$('#create-chapter-title').on('click input', function () {
    saveChapterData($(this).val(), 'title');
});

$('#editor').on('click input', '.ql-editor', function () {
    saveChapterData($(this).html(), 'text');
});


const chapter_position = $('#create-chapter-chapter_position'),
    section_position = $('#create-chapter-section_position');

// изменение положения относительно раздела
section_position.on('change', function() {
    saveChapterData($(this).val(), 'section_position');
});
chapter_position.on('change', function () {
    saveChapterData($(this).val(), 'chapter_position');
});


function saveChapterData(data, session_key) {
    $.ajax({
        url: 'http://inkwell/web/author/modify/save-chapter-data',
        type: 'post',
        data: {data: data, session_key: session_key},
        success: function (response) {
            //console.log(response);
            if (response) if (response.chapters) updateChapters(chapter_position, response.chapters);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function setCaret(node) {
    let range = document.createRange();
    range.selectNodeContents(node);
    range.collapse(false);

    let selection = window.getSelection();
    selection.removeAllRanges();
    selection.addRange(range);
}

function updateChapters(select, chapters) {
    let to_add = '<option value="0">В начале</option>';
    $.each(chapters, function (key, value) {
        //console.log(value)
        to_add += `<option value="${value.id}">После "${value.title}"</option>`;
    });
    select.html(to_add);
}