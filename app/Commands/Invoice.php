<?php

namespace App\Commands;

use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Invoice extends BaseCommand
{

    function processCommand($text = false)
    {
        $callback_data = json_decode($this->update->getCallbackQuery()->getData(), true);

        $this->getBot()->sendInvoice($this->user->chat_id, 'ОСББ', 'На данний момент Вам треба оплатити',
            'test', env('TRANZZO_KEY'), 'test', 'UAH', [
                [
                    'label' => 'test',
                    'amount' => $callback_data['c']
                ]
            ]);
    }

}