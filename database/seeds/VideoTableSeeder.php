<?php

use App\Channel;
use App\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class VideoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channel = new Channel();
        $channel->name = "Channel Uno";
        $channel->thumbnail = "";
        $channel->description = "Lorem ipsum dolor sit amet";
        $channel->save();

        $video = new Video();
        $video->title = "Uno Video";
        $video->video_id = "TtpX0NHU3hI";
        $video->url = "https://www.youtube.com/watch?v=TtpX0NHU3hI";
        $video->thumbnail = "https://img.youtube.com/vi/TtpX0NHU3hI/hqdefault.jpg";
        $video->description = "Lorem ipsum dolor sit amet";
        $video->channel_id = 1;
        $video->category_id = 1;
        $video->subcategory_id = 1;
        $video->published_at = Carbon::now()->toDateTimeString();
        $video->save();

        $video->labels()->sync(1);
    }
}
