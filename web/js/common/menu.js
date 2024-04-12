let menu_button = document.querySelector('#menu-button');
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
}


let menu_content = document.querySelector('.main-menu-content');
let menu_container = document.querySelector('.main-menu-container');
function toggle_menu() {
    menu_content.classList.toggle("hidden");
}
document.addEventListener('click', function(event) {
    if (!menu_container.contains(event.target)) {
        menu_content.classList.add('hidden');
    }
})