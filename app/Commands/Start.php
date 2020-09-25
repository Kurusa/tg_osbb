<?php

namespace App\Commands;

class Start extends BaseCommand
{

    function processCommand()
    {
        $this->getBot()->sendMessage($this->user->chat_id, 'Вітаємо!
Цей бот для мешканців ЖК «Панорама на Лесницькій»
В цьому боті Ви можете оплатити он-лайн комунальні платежі , перевірити стан свого рахунку та знайти контактні телефони у разі виникнення питань. ');
        $this->triggerCommand(MainMenu::class);
    }

}

