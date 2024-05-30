let menu = $('.side-menu');
$('#menu-button').on('click', function () {
    $.ajax({
        url: 'http://inkwell/web/main/toggle-side-menu',
        type: 'post',
        success: function (response) {
            if (response.is_open === true) {
                let styleSheet = $("<link>");
                styleSheet.attr({
                    rel:  "stylesheet",
                    type: "text/css",
                    href: "/web/css/menu/active.css"
                });
                $("head").append(styleSheet);
            }
            else $(`link[href="/web/css/menu/active.css"]`).remove();
        },
        error: function (error) {
            console.log(error);
        }
    });
});


$('.extendable-menu-item').on('click', function () {
    $(this).find('.closed-menu-tooltip').removeClass('hidden');
    $(this).addClass('highlight-svg');
});
$(document).on('click', function (e) {
    if (!$(e.target).closest('#extendable-author').length) {
        let element = $('#extendable-author');
        element.removeClass('highlight-svg');
        element.find('.closed-menu-tooltip').addClass('hidden');
    }
    if (!$(e.target).closest('#extendable-reader').length) {
        let element = $('#extendable-reader');
        element.removeClass('highlight-svg');
        element.find('.closed-menu-tooltip').addClass('hidden');
    }
    if (!$(e.target).closest('#extendable-moderator').length) {
        let element = $('#extendable-moderator');
        element.removeClass('highlight-svg');
        element.find('.closed-menu-tooltip').addClass('hidden');
    }
    if (!$(e.target).closest('#extendable-admin').length) {
        let element = $('#extendable-admin');
        element.removeClass('highlight-svg');
        element.find('.closed-menu-tooltip').addClass('hidden');
    }
});


let menu_content = $('.main-menu-content');
let menu_container = $('.main-menu-container');
function toggle_menu() {
    menu_content.toggleClass("hidden");
}
$(document).on('click', function(event) {
    if (!menu_container[0].contains(event.target)) {
        menu_content.addClass('hidden');
    }
})



// запоминает открытие пунктов
$('#author-details').on('click', function() {
     $.ajax('http://inkwell/web/main/remember-details?name=author')
});
$('#reader-details').on('click', function() {
    $.ajax('http://inkwell/web/main/remember-details?name=reader')
});
$('#moderator-details').on('click', function() {
    $.ajax('http://inkwell/web/main/remember-details?name=moderator')
});
$('#admin-details').on('click', function() {
    $.ajax('http://inkwell/web/main/remember-details?name=admin')
});