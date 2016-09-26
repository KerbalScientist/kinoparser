<?php

return [
    'class' => 'app\components\KinopoiskParser',
    'urlTemplate' => 'https://www.kinopoisk.ru/s/type/film/list/1/m_act[year]/#year#/',
    'filmContainersXpath' => "//div[contains(@class, 'search_results')]/div[contains(@class,'element')]",
    'fieldsXpath' =>[
        'title' => "string(./div[@class='info']/p[@class='name']/a)",
        'url' => "concat('https://www.kinopoisk.ru/film/', ./p[@class='pic']/a/@data-id, '/')",
        // Rating rounded to one digit after point.
        //'rating' => "string(./div[@class='right']/div[contains(@class,'rating')])",
        // Rating rounded to 3 digits after point.
        'rating' => "substring-before(./div[@class='right']/div[contains(@class,'rating')]/@title, ' ')",
        'externalId' => "string(./p[@class='pic']/a/@data-id)"
    ],
];

