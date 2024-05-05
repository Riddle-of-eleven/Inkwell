const title_length= 150;
const description_length= 800;
const remark_length= 2000;
const other_length= 500;

let content = $('.step-content');

$(document).ready(function() {
    // вопрос, насколько это будет нужно, если оно загружается уже с некоторыми данными
    // а ещё это явно должен быть не ready, потому что загрузка section происходит позже
    /*countSymbolsFromField($('#step-meta-title'), title_length);
    countSymbolsFromField($('#step-meta-description'), description_length);
    countSymbolsFromField($('#step-meta-remark'), remark_length);
    countSymbolsFromField($('#step-meta-disclaimer'), other_length);
    countSymbolsFromField($('#step-meta-dedication'), other_length);*/
});

// подсчёт количества символов в полях
content.on('input', '#step-meta-title', function () {
    countSymbolsFromField($(this), title_length);
});
content.on('input', '#step-meta-description', function () {
    countSymbolsFromField($(this), description_length);
});
content.on('input', '#step-meta-remark', function () {
    countSymbolsFromField($(this), remark_length);
});
content.on('input', '#step-meta-disclaimer', function () {
    countSymbolsFromField($(this), other_length);
});
content.on('input', '#step-meta-dedication', function () {
    countSymbolsFromField($(this), other_length);
});