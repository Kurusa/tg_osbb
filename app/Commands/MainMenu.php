<?php

namespace App\Commands;

use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class MainMenu extends BaseCommand
{

    function processCommand($text = false)
    {
        $this->user->status = UserStatusService::DONE;
        $this->user->save();

        $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Головне меню', new ReplyKeyboardMarkup([
            ['Особистий кабінет', 'Зворотній зв\'язок'],
        ], false, true));
    }

}