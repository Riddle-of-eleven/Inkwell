let preview = $('.cover-preview');
let result = $('#result');
let input = $(cover);
let label = $('.upload-container');
let image_preview = $('#image-preview');

let cropper;
let crop_button = $('#button-crop');
let restore_button = $('#button-restore');

input.on('change', function(e) {
    image_preview.html($('<img>').attr('src', ''));
    preview.removeClass('hidden');
    let files = e.target.files;
    let done = function (url) {
        let image = image_preview.find('img')[0];
        input.value = '';
        image.src = url;
        if (cropper) cropper.destroy();
        cropper = new Cropper(image, {
            aspectRatio: 6 / 9, // Например, квадратное изображение
            viewMode: 1,
            scalable: false,
            zoomable: false,
            rotatable: false,
            movable: false,
            height: 360
        });
    };

    if (files && files.length > 0) {
        let file = files[0];
        if (URL) done(URL.createObjectURL(file));
        else if (FileReader) {
            let reader = new FileReader();
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});

crop_button.on('click', function() {
    if (cropper) {
        let canvas = cropper.getCroppedCanvas({
            fillColor: '#ffffff'
        });

        canvas.toBlob(function (blob) {
            let form_data = new FormData();
            form_data.append('cropped_image', blob);
            $.ajax({
                url: 'http://inkwell/web/author/create/upload-cover',
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                },
                error: function() {
                    console.error('Ошибка при загрузке');
                }
            });
        }, 'image/png');

        let cropped = canvas.toDataURL("image/png");
        cropper.destroy();
        image_preview.html($('<img class="crop-result block">').attr('src', cropped));
        $('#button-crop').addClass('hidden');
    }
});
restore_button.on('click', function () {
    preview.addClass('hidden');
    if (cropper) cropper.destroy();
    image_preview.empty();
    crop_button.removeClass('hidden');
    $.ajax('http://inkwell/web/author/create/remove-cover');
});



// drag`n`drop и то, что его касается
label.on('dragover', function (e) {
    e.preventDefault(); e.stopPropagation();
    $(this).addClass('dragover')
});
label.on('dragleave', function (e) {
    e.preventDefault(); e.stopPropagation();
    $(this).removeClass('dragover');
});
label.on('drop', function (e) {
    e.preventDefault(); e.stopPropagation();
    label.removeClass('dragover');
    let files = e.originalEvent.dataTransfer.files;
    if (files.length > 0) {
        input[0].files = files;
        input.trigger('change');
    }
});