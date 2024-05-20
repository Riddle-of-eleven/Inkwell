$('.tab').click(function () {
    loadTab('user/settings', $(this).data('tab'), $('.tab-contents'));
});