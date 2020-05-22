<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class NewVideo extends Notification
{
    use Queueable;

    private $channelName, $videoTitle, $videoID;

    /**
     * NewVideo constructor.
     * @param $channelName
     * @param $videoTitle
     * @param $videoID
     */
    public function __construct($channelName, $videoTitle, $videoID)
    {
        $this->channelName = $channelName;
        $this->videoTitle = $videoTitle;
        $this->videoID = $videoID;

    }

    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData([
                'type' => 'NEW_VIDEO',
                'videoID' => strval($this->videoID),
            ])
            ->setNotification(
                \NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle('Video Baru dari ' . $this->channelName)
                    ->setBody($this->videoTitle)
            );
    }
}
