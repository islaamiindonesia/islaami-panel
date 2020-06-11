<?php

namespace App\Http\Controllers\API;

use App\Channel;
use App\Http\Controllers\Controller;
use App\User;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $authID = auth('api')->id();

        $channels = Channel::where('suspended_at', null)->get();

        $channelArray = array();
        foreach ($channels as $channel) {
            $channel->is_followed = Channel::find($channel->id)->followers->contains($authID);
            $channel->followers = $channel->followers()->count();
            if (!Channel::find($channel->id)->blacklists->contains($authID)) {
                array_push($channelArray, $channel);
            }
        }

        return $this->successResponseWithData($channelArray);
    }

    /**
     * Get followed channel.
     *
     * @return JsonResponse
     */
    public function indexFollow(Request $request)
    {
        $authID = auth('api')->id();

        $user = User::find($authID);

        $channels = $user->followChannels();

        if ($request->has("query")) {
            $channels->name($request->query('query'));
        }

        $channelArray = array();
        foreach ($channels->get() as $channel) {
            $channel->followers = $channel->followers()->count();
            if (Channel::find($channel->id)->followers->contains($authID) &&
                !Channel::find($channel->id)->blacklists->contains($authID)) {
                array_push($channelArray, $channel);
            }
        }


        return $this->successResponseWithData($channelArray);
    }

    /**
     * Videos by Channel.
     *
     * @return JsonResponse
     */
    public function videosChannel($id)
    {
        $now = Carbon::now()->toDateTimeString();

        $videos = Channel::find($id)->videos()->withCount('views as views')
            ->with([
                'channel' => function ($query) {
                    $query->select(['id', 'name', 'thumbnail']);
                },
                'category' => function ($query) {
                    $query->select(['id', 'name']);
                },
                'subcategory' => function ($query) {
                    $query->select(['id', 'name']);
                },
                'labels'
            ])
            ->where('published_at', '<=', $now)
            ->orderBy('published_at', 'desc');

        $videoArray = array();
        foreach ($videos->paginate(10)->toArray()["data"] as $video) {
            $video["is_saved_later"] = Video::find($video["id"])->users->contains($video["id"]);
            array_push($videoArray, $video);
        }

        return $this->successResponseWithData($videoArray);
    }

    /**
     * Get blacklisted channel.
     *
     * @return JsonResponse
     */
    public function indexBlacklist()
    {
        $authID = auth('api')->id();

        $user = User::find($authID);

        $channels = $user->blacklistChannels()->get();

        $channelArray = array();
        foreach ($channels as $channel) {
            $channel->is_followed = Channel::find($channel->id)->followers->contains($authID);
            $channel->followers = $channel->followers()->count();
            array_push($channelArray, $channel);
        }

        return $this->successResponseWithData($channelArray);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $authID = auth('api')->id();
        $channel = Channel::where('id', $id)->where('suspended_at', null)->first();

        $channel->is_followed = Channel::find($id)->followers->contains($authID);
        $channel->followers = $channel->followers()->count();
        $channel->videos = $channel->videos()->count();

        if (Channel::find($id)->blacklists->contains($authID)) {
            return $this->errorResponse("CHANNEL_BLACKLISTED", 401);
        }

        return $this->successResponseWithData($channel);
    }

    /**
     * Follow Channel.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function follow($id)
    {
        $user = User::find(auth('api')->id());

        if (!$user->followChannels->contains($id)) {
            $user->followChannels()->attach($id);
        }

        return $this->successResponse();
    }

    /**
     * Un-Follow Channel.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function unfollow($id)
    {
        $user = User::find(auth('api')->id());

        $user->followChannels()->detach($id);

        return $this->successResponse();
    }

    /**
     * Blacklist Channel.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function addBlackList($id)
    {
        $user = User::find(auth('api')->id());

        if (!$user->blacklistChannels->contains($id)) {
            $user->blacklistChannels()->attach($id);
        }

        return $this->successResponse();
    }

    /**
     * Un-Blacklist Channel.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function removeBlackList($id)
    {
        $user = User::find(auth('api')->id());

        $user->blacklistChannels()->detach($id);

        return $this->successResponse();
    }
}
