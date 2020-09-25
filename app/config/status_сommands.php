<?php

use App\Services\Status\UserStatusService;

return [
    UserStatusService::SET_ROOM_NUMBER => \App\Commands\SetRoomNumber::class,
    UserStatusService::SET_PERSONAL_NUMBER => \App\Commands\SetPersonalNumber::class,
];