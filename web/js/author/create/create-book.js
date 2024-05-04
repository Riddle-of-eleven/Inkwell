$(document).ready(function() {
    loadStepByName('1_main');
});


// загрузка вкладок
$('.step').click(function () {
    loadStepByName($(this).data('step'));
});