<?php

namespace App\Http\Controllers\API;

use App\Channel;
use App\Http\Controllers\Controller;
use App\User;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $authID = auth('api')->id();
        $now = Carbon::now()->toDateTimeString();

        $videos = Video::withCount('views as views')
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
            ->where('drafted_at', null)
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $videoArray = array();
        foreach ($videos->toArray()["data"] as $video) {
            $video["is_saved_later"] = Video::find($video["id"])->users->contains($video["id"]);
            $video["channel"]["is_followed"] = Channel::find($video["channel"]["id"])->followers->contains($authID);
            if (!Channel::find($video["channel"]["id"])->blacklists->contains($authID)) {
                array_push($videoArray, $video);
            }
        }

        return $this->successResponseWithData($videoArray);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function indexFollowing()
    {
        $authID = auth('api')->id();
        $now = Carbon::now()->toDateTimeString();

        $videos = Video::withCount('views as views')
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
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $videoArray = array();
        foreach ($videos->toArray()["data"] as $video) {
            $video["is_saved_later"] = Video::find($video["id"])->users->contains($video["id"]);
            $video["channel"]["is_followed"] = Channel::find($video["channel"]["id"])->followers->contains($authID);
            if (!Channel::find($video["channel"]["id"])->blacklists->contains($authID) &&
                $video["channel"]["is_followed"]) {

                array_push($videoArray, $video);
            }
        }

        return $this->successResponseWithData($videoArray);
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
        $video = Video::where('id', $id)->first();
        if ($video != null) {
            $user = User::find($authID);
            $user->videoView()->attach($video->id);

            $video = Video::where('id', $id)
                ->withCount('views as views')
                ->with([
                    'channel' => function ($query) {
                        $query->select(['id', 'name', 'thumbnail', 'description']);
                        $query->withCount('followers as followers');
                    },
                    'category' => function ($query) {
                        $query->select(['id', 'name']);
                    },
                    'subcategory' => function ($query) {
                        $query->select(['id', 'name']);
                    },
                    'labels'
                ])
                ->first();

            $video->is_saved_later = Video::find($video->id)->users->contains($video->id);
            $video->channel->is_followed = Channel::find($video->channel->id)->followers->contains($authID);
            return $this->successResponseWithData($video);
        }

        return $this->errorResponse("VIDEO_NOT_FOUND", 404);
    }
}
