<?php

namespace App\Commands;

use App\Services\Status\UserStatusService;
use Google_Client;
use Google_Service_Sheets;
use Mosquitto\Exception;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class SetRoomNumber extends BaseCommand
{

    function processCommand($text = false)
    {
        if ($this->user->status === UserStatusService::SET_ROOM_NUMBER) {
            if ($this->update->getMessage()->getText() === 'скасувати') {
                $this->triggerCommand(MainMenu::class);
            } else {
                $this->user->room_number = $this->update->getMessage()->getText();
                $this->user->save();

                $this->triggerCommand(SetPersonalNumber::class);
            }
        } else {
            $this->user->status = UserStatusService::SET_ROOM_NUMBER;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Введіть номер Вашої квартири 
(Тільки цифри)', new ReplyKeyboardMarkup([
                ['скасувати'],
            ], false, true));
        }
    }

}