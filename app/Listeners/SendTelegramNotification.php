<?php

namespace App\Listeners;

use App\Events\FeedbackCreate;
use App\Models\Feedback;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class SendTelegramNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FeedbackCreate $event): void
    {
        $message = $this->getMessage($event->feedback);
        $apiKey = config('telegram.api_key');

        if ($event->feedback->institution->city == 'Краснодар') {
            $chatId = config('telegram.chat_id_krasnodar');

            Http::post("https://api.telegram.org/bot{$apiKey}/sendMessage", [
                'chat_id' => '-4281880650',
                'text' => $message,
            ]);

        } elseif ($event->feedback->institution->city == 'Анапа') {
            $chatId = config('telegram.chat_id_anapa');
        } else {
            $chatId = config('telegram.chat_id_sochi');
        }

        Http::post("https://api.telegram.org/bot{$apiKey}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }

    public function getMessage(Feedback $feedback): string
    {
        $dateTime = $feedback->date . ', ' . $feedback->time;
        $feedback->load('institution');
        $data = [
            'institution_name' => $feedback->institution->name,
            'institution_type' => $feedback->institution->type,
            'name' => $feedback->name,
            'phone' => $feedback->phone,
            'date_time' => $dateTime,
            'count_guests' => $feedback->count_guests,
            'comment' => $feedback->comment,
        ];

        $messageOut = 'Бронирование с сайта' . "\n";
        $messageOut .= 'Заведение : ' . $data['institution_type'] . ' - ' . $data['institution_name'] . "\n";
        $messageOut .= 'Имя клиента : ' . $data['name'] . "\n";
        $messageOut .= 'Телефон : ' . $data['phone'] . "\n";
        $messageOut .= 'Дата и время : ' . $data['date_time'] . "\n";
        $messageOut .= 'Количество гостей : ' . $data['count_guests'] . "\n";
        $messageOut .= 'Комментарий : ' . $data['comment'] . "\n";

        return $messageOut;
    }
}
