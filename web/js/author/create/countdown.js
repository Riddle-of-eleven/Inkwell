const title_length= 150;
const description_length= 800;
const remark_length= 2000;
const other_length= 500;

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