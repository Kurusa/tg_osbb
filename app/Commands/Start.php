<?php

namespace App\Commands;

use App\Services\Status\UserStatusService;

class Start extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::NEW) {
            $this->triggerCommand(LanguageSelect::class);
        } elseif ($this->user->status === UserStatusService::DONE || $this->user->status === UserStatusService::FORECAST_CITY_SELECT) {
            $this->triggerCommand(MainMenu::class);
        }
    }

}

