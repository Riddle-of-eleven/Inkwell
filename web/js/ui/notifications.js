function showMessage(text, state) {
    let notification = $(`<div class="notification notification-${state}">${text}</div>`);
    $("body").append(notification);

    // Через 3 секунды скрываем уведомление
    setTimeout(function() {
        notification.fadeOut();
    }, 3000);
}