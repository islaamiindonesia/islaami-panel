<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class AfterRegister extends Notification
{
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(['type' => 'VERIFICATION', 'forUserEmail' => $notifiable->email])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('Kode Verifikasi')
                ->setBody('Kode Anda: ' . $notifiable->verification_number));
        /*
        ->setAndroid(
            AndroidConfig::create()
                ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
        )->setApns(
            ApnsConfig::create()
                ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));*/
    }
}
