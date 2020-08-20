<?php


namespace App\Channels;


use Illuminate\Notifications\Notification;

class TestChannel
{
    public function send($notifiable, Notification $notification)
    {
        $end_point = $notifiable->notificationURL;
        $http_header = [
            "Content-Type: Application/Json",
        ];
        $req_data = [
            'uuid' => $notifiable->uuid,
        ];

//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
//        curl_setopt($ch, CURLOPT_URL, $end_point );
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req_data) );
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $response = curl_exec($ch);
    }
}
