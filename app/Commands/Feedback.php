<?php

namespace App\Commands;

use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Feedback extends BaseCommand
{

    function processCommand($text = false)
    {
        $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Якщо у Вас виникли питання зателефонуйте : 
Голова Осбб ЖК Панорама на Лесницькій +3800000000000
Бухгалтер +380000000
Охорона +3805000000', new ReplyKeyboardMarkup([
            ['Особистий кабінет', 'Зворотній зв\'язок'],
        ], false, true));
    }

}