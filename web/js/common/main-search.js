const search = $('#main-search')[0],
    form = $('#main-search-form');

search.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        form.submit();
    }
});