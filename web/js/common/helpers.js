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
                    let to_append = `<div class="dropdown-item" id="${id}" ${type_name}="${value.id}">
                        <div class="metadata-title">${value.title}</div>`;
                    if (value.description) to_append += `<div class="metadata-description tip">${value.description}</div>`;
                    to_append += `</div>`;
                    select.append(to_append);
                });
            else select.append('<div class="tip-color dropdown-item empty-dropdown-item">Ничего не найдено</div>');
        },
        error: function (error) {
            console.log(error);
        }
    });
}