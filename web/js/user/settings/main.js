$('.tab').click(function () {
    loadTab('user/settings', $(this).data('tab'), $('.tab-contents'));
});



// обрезка изображения

let cropper;

$(document).on('change', '#user-avatar', function(e) {
    $('#image-preview').html($('<img>').attr('src', ''));
    $('#image-preview').removeClass('avatar-image-preview');
    $('.avatar-preview').removeClass('hidden');
    $('#button-crop').removeClass('hidden');
    let files = e.target.files;
    let done = function (url) {
        let image = $('#image-preview').find('img')[0];
        $('#user-avatar').value = '';
        image.src = url;
        if (cropper) cropper.destroy();
        cropper = new Cropper(image, {
            aspectRatio: 1, // Например, квадратное изображение
            viewMode: 1,
            scalable: false,
            zoomable: false,
            rotatable: false,
            movable: false,
            height: 300
        });
    };

    if (files && files.length > 0) {
        let file = files[0];
        if (URL) done(URL.createObjectURL(file));
        else if (FileReader) {
            let reader = new FileReader();
            reader.onload = function (e) {
                done(reader.$('#result'));
            };
            reader.readAsDataURL(file);
        }
    }
});

$(document).on('click', '#button-crop', function() {
    if (cropper) {
        let canvas = cropper.getCroppedCanvas({
            fillColor: '#ffffff'
        });

        canvas.toBlob(function (blob) {
            let form_data = new FormData();
            form_data.append('cropped_image', blob);
            $.ajax({
                url: 'index.php?r=user/settings/set-avatar',
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
        $('#image-preview').html($('<img class="crop-result">').attr('src', cropped));
        $('#button-crop').addClass('hidden');
    }
});

$(document).on('click', '#button-restore', function () {
    $.ajax('index.php?r=user/settings/delete-avatar');
    $('.avatar-preview').addClass('hidden');
    if (cropper) cropper.destroy();
    $('#image-preview').empty();
});



// drag`n`drop и то, что его касается
$(document).on('dragover', '.upload-container', function (e) {
    e.preventDefault(); e.stopPropagation();
    $(this).addClass('dragover')
});
$(document).on('dragleave', '.upload-container', function (e) {
    e.preventDefault(); e.stopPropagation();
    $(this).removeClass('dragover');
});
$(document).on('drop', '.upload-container', function (e) {
    e.preventDefault(); e.stopPropagation();
    $('.upload-container').removeClass('dragover');
    $('#image-preview').removeClass('avatar-image-preview');
    $('#button-crop').removeClass('hidden');
    let files = e.originalEvent.dataTransfer.files;
    if (files.length > 0) {
        $('#user-avatar')[0].files = files;
        $('#user-avatar').trigger('change');
    }
});