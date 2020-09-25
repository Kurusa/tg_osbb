<?php
return [
    'feedback' => \App\Commands\Feedback::class,
    'settings' => \App\Commands\Settings::class,
    'changeLang' => \App\Commands\LanguageSelect::class,
    'changeCity' => \App\Commands\CityMenu::class,
    'myCityList' => \App\Commands\UserCityList::class,
    'addCity' => \App\Commands\LocationTypeSelect::class,
    'forecast' => \App\Commands\Weather\WeatherLess::class,
];