<?php

namespace App\Jobs;

use App\Notifications\NewVideo;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendVideoUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $channelName, $videoTitle, $videoID;
    private $user;

    /**
     * SendVideoUpdate constructor.
     * @param User $user
     * @param $channelName
     * @param $videoTitle
     * @param $videoID
     */
    public function __construct(User $user, $channelName, $videoTitle, $videoID)
    {
        $this->user = $user;
        $this->channelName = $channelName;
        $this->videoTitle = $videoTitle;
        $this->videoID = $videoID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new NewVideo($this->channelName, $this->videoTitle, $this->videoID));
    }
}
