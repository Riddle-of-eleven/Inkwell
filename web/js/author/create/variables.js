const
    // секция содержимого шагов
    content = $('.step-content'),

    // вводимые данные
    title = '#step-meta-title',
    description = '#step-meta-description',
    remark = '#step-meta-remark',
    disclaimer = '#step-meta-disclaimer',
    dedication = '#step-meta-dedication',

    genres = '#step-meta-genres',
    tags = '#step-meta-tags',

    book_type = '#step-meta-book_type',
    fandoms = '#step-meta-fandoms',
    origins = '#step-meta-origins',

    characters = '#step-meta-characters',
    pairings = '#step-meta-pairings',
    fandom_tags = '#step-meta-fandom_tags';

const
    cancel_icon = `<svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon cancel-icon">
        <path d="m339-301.847 141-141 141 141L658.153-339l-141-141 141-141L621-658.153l-141 141-141-141L301.847-621l141 141-141 141L339-301.847Zm141.067 185.846q-74.836 0-141.204-28.42-66.369-28.42-116.182-78.21-49.814-49.791-78.247-116.129-28.433-66.337-28.433-141.173 0-75.836 28.42-141.704 28.42-65.869 78.21-115.682 49.791-49.814 116.129-78.247 66.337-28.433 141.173-28.433 75.836 0 141.704 28.42 65.869 28.42 115.682 78.21 49.814 49.791 78.247 115.629 28.433 65.837 28.433 141.673 0 74.836-28.42 141.204-28.42 66.369-78.21 116.182-49.791 49.814-115.629 78.247-65.837 28.433-141.673 28.433ZM480-168q130 0 221-91t91-221q0-130-91-221t-221-91q-130 0-221 91t-91 221q0 130 91 221t221 91Zm0-312Z" />
    </svg>`,
    delete_icon = `<svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon delete-icon">
        <path d="M324.309-164.001q-26.623 0-45.465-18.843-18.843-18.842-18.843-45.465V-696h-48v-51.999H384v-43.384h192v43.384h171.999V-696h-48v467.257q0 27.742-18.65 46.242-18.65 18.5-45.658 18.5H324.309ZM648-696H312v467.691q0 5.385 3.462 8.847 3.462 3.462 8.847 3.462h311.382q4.616 0 8.463-3.846 3.846-3.847 3.846-8.463V-696ZM400.155-288h51.999v-336h-51.999v336Zm107.691 0h51.999v-336h-51.999v336ZM312-696V-216v-480Z"/>
    </svg>`,
    expand_icon = `<svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon">
        <path d="M480-346.463 253.847-572.615 291-609.768l189 189 189-189 37.153 37.153L480-346.463Z"/>
    </svg>`;