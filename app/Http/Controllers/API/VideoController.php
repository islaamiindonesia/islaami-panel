<?php

namespace App\Http\Controllers\API;

use App\Channel;
use App\Http\Controllers\Controller;
use App\User;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
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
            ->orderBy('rand()');

        if ($request->has("query")) {
            $videos = $videos->searchTitle($request->query('query'));
        }

        $videoArray = array();
        foreach ($videos->paginate(100)->toArray()["data"] as $video) {
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
            ->whereIn('channel_id', User::find($authID)->followChannels->pluck('id'))
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
            $videoView = $user->videoView()->where('user_id', $authID)->where('video_views.video_id', $id)->first();
            if ($videoView == null) {
                $user->videoView()->attach($id);
            }

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
