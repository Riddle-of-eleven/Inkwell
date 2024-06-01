const search = $('#main-search');

search.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
    }
});