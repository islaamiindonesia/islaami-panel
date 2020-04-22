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
            return $this->errorResponse("CHANNEL_BLACKLISTED", 401);
        }

        $channel->followers = $channel->followers()->count();
        $channel->videos = $channel->videos()->count();

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
        if ($user->blacklistChannels->contains($id)) {
            return $this->errorResponse("DATA_EXIST");
        }

        $user->blacklistChannels()->attach($id);

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
