<?php

namespace App\Commands;

use App\Services\Status\UserStatusService;
use Google_Client;
use Google_Service_Sheets;
use Mosquitto\Exception;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\Payments\LabeledPrice;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class SetPersonalNumber extends BaseCommand
{

    function processCommand($text = false)
    {
        if ($this->user->status === UserStatusService::SET_PERSONAL_NUMBER) {
            if ($this->update->getMessage()->getText() === 'скасувати') {
                $this->triggerCommand(MainMenu::class);
            } else {
                $client = $this->getClient();
                $service = new Google_Service_Sheets($client);
                $spreadsheet_id = '1TwwZ2i766NrGllQVTyGl5sqG2ajrGWsKS6zACBexzxM';
                $range = 'A2:C';

                try {
                    $response = $service->spreadsheets_values->get($spreadsheet_id, $range);
                } catch (\Exception $e) {
                    $this->getBot()->sendMessage($this->user->chat_id, $e->getMessage());
                }
                $values = $response->getValues();

                if (!empty($values)) {
                    foreach ($values as $row) {
                        if ($row[0] == $this->user->room_number && trim($row[1]) == trim($this->update->getMessage()->getText())) {
                            $amount = str_replace(',', '', $row[2]);
                            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'На данний момент Вам треба оплатити: ' . $row[2] . ' грн', new InlineKeyboardMarkup([
                                [
                                    [
                                        'text' => 'Оплатити',
                                        'callback_data' => json_encode([
                                            'a' => 'invoice',
                                            'c' => preg_replace("/[^0-9]/", '', $amount)
                                        ])
                                    ],
                                    [
                                        'text' => 'Квитанція в pdf',
                                        'callback_data' => json_encode([
                                            ''
                                        ])
                                    ],
                                ],
                            ], false, true));
                            $found = true;
                            $this->triggerCommand(MainMenu::class);
                            break;
                        }
                    }
                } else {
                    $this->getBot()->sendMessage($this->user->chat_id, 'Квартиру з цим номером не знайдено');
                }

                if (!$found) {
                    $this->getBot()->sendMessage($this->user->chat_id, 'Квартиру з цим номером не знайдено');
                }
            }
        } else {
            $this->user->status = UserStatusService::SET_PERSONAL_NUMBER;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Введіть номер Вашого особового рахунку (великі літери і цифри без пробілів)', new ReplyKeyboardMarkup([
                ['скасувати'],
            ], false, true));
        }
    }

    function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = __DIR__ . '/../../token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

}