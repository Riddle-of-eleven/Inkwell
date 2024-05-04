// загрузка вкладок
$(document).ready(function() {
    loadStepByName('1_main');
});
$('.step').click(function () {
    loadStepByName($(this).data('step'));
});


