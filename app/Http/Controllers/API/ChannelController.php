<?php

namespace App\Http\Controllers\API;

use App\Channel;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;

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

        $channels = Channel::where('suspended_at', null)->doesntHave('blacklists')->get();

        foreach ($channels as $channel) {
            $channel->is_followed = Channel::find($channel->id)->followers->contains($authID);
            $channel->followers = $channel->followers()->count();
        }

        return $this->successResponseWithData($channels);
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

        if (Channel::find($id)->followers->contains($authID)) {
            $channel->is_followed = true;
        } else {
            $channel->is_followed = false;
        }

        if (Channel::find($id)->blacklists->contains($authID)) {
            $channel->is_blacklisted = true;
        } else {
            $channel->is_blacklisted = false;
        }
        $channel->followers = $channel->followers()->count();

        $videos = $channel->videos()->get();

        $videoArray = array();
        foreach ($videos as $video) {
            $video->channel;
            $video->category;
            $video->subcategory;
            $video->labels;
            $video->views = $video->views()->count();

            array_push($videoArray, $video);
        }

        $channel->videos = $videoArray;

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
        if ($user->followChannels->contains($id)) {
            return $this->errorResponse("DATA_EXIST");
        }

        $user->followChannels()->attach($id);

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
        if ($user->blacklists->contains($id)) {
            return $this->errorResponse("DATA_EXIST");
        }

        $user->blacklists()->attach($id);

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

        $user->blacklists()->detach($id);

        return $this->successResponse();
    }
}
