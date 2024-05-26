let menu = $('.side-menu');
$('#menu-button').on('click', function () {
    $.ajax({
        url: 'index.php?r=main/toggle-side-menu',
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



/*let menu_button = document.querySelector('#menu-button');
let sidebar = document.querySelector('.side-menu');
let body = document.body;

let login = document.querySelector('#link-login');
let register = document.querySelector('#link-register');

let is_open = localStorage.getItem('is_open') == 'true';
if (is_open) {
    sidebar.classList.add('active');
    body.classList.add('active-body');

    if (login) login.classList.add('button-left-align');
    if (register) register.classList.add('button-left-align');

    if (login) login.classList.remove('small-button');
    if (register) register.classList.remove('small-button');
}

menu_button.onclick = function () {
    sidebar.classList.toggle('active');
    body.classList.toggle('active-body');

    if (login) login.classList.toggle('small-button');
    if (register) register.classList.toggle('small-button');

    if (login) login.classList.toggle('button-left-align');
    if (register) register.classList.toggle('button-left-align');

    localStorage.setItem('is_open', !is_open);
}*/


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