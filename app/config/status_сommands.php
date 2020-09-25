<?php

use App\Services\Status\UserStatusService;

return [
    UserStatusService::SET_START_LANGUAGE => \App\Commands\LanguageSelect::class,
    UserStatusService::SET_LANGUAGE => \App\Commands\LanguageSelect::class,
    UserStatusService::LOCATION_TYPE_SELECT => \App\Commands\SelectLocation\SelectLocationType::class,
    UserStatusService::SETTINGS_LOCATION_TYPE_SELECT => \App\Commands\SelectLocation\SelectLocationType::class,
    UserStatusService::SETTINGS_DISTRICT_SELECT => \App\Commands\SelectLocation\DistrictSelect::class,
    UserStatusService::CITY_NAME => \App\Commands\SelectLocation\ByCityName::class,
    UserStatusService::LOCATION_WAITING => \App\Commands\SelectLocation\ByTgLocation::class,
    UserStatusService::LOCATION_SELECTING => \App\Commands\SelectLocation\LocationDone::class,
    UserStatusService::SETTINGS_LOCATION_SELECTING => \App\Commands\SelectLocation\LocationDone::class,
    UserStatusService::SETTINGS_CITY_NAME => \App\Commands\SelectLocation\ByCityName::class,
    UserStatusService::DISTRICT_SELECT => \App\Commands\SelectLocation\DistrictSelect::class,
    UserStatusService::FEEDBACK => \App\Commands\Feedback::class,
    UserStatusService::USER_CITY_LIST => \App\Commands\UserCityList::class,
    UserStatusService::FORECAST_CITY_SELECT => \App\Commands\Weather\WeatherLess::class,
];