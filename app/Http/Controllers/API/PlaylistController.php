<?php

namespace App\Http\Controllers\API;

use App\Channel;
use App\Http\Controllers\Controller;
use App\Playlist;
use App\User;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.api:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $authID = auth('api')->id();
        $playlists = Playlist::where('user_id', $authID)->get();
        foreach ($playlists as $playlist) {
            $playlist->video_count = $playlist->videos()->count();
        }

        return $this->successResponseWithData($playlists);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $authID = auth('api')->id();
        $playlist = new Playlist();
        $playlist->name = $request->name;
        $playlist->user_id = $authID;
        $playlist->save();

        return $this->successResponseWithData($playlist);
    }

    /**
     * Add video to playlist
     *
     * @param Request $request
     * @param int $id
     * @param null $videoId
     * @return JsonResponse
     */
    public function addVideo(Request $request, $id)
    {
        $authID = auth('api')->id();
        $playlist = User::find($authID)->playlists()->where('id', $id)->first();

        if (!$playlist->videos->contains($request->video_id)) {
            $playlist->videos()->attach($request->video_id);
        }

        return $this->successResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, $id)
    {
        $authID = auth('api')->id();
        $playlist = User::find($authID)->playlists()->where('id', $id)->first();

        if ($playlist != null) {
            $videoArray = array();
            foreach ($playlist->videos()->get() as $video) {
                $video->channel;
                $video->category;
                $video->subcategory;
                $video->labels;
                $video->views = $video->views()->count();

                array_push($videoArray, $video);
            }

            $playlist->video_count = $playlist->videos()->count();

            if ($request->has("query")) {
                $playlist->videos = $playlist->videos()->where('title', 'LIKE', "%{$request->query('query')}%")->get();
            } else {
                $playlist->videos = $videoArray;
            }

            return $this->successResponseWithData($playlist);
        }

        return $this->errorResponse("PLAYLIST_NOT_FOUND", 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $authID = auth('api')->id();
        $playlist = User::find($authID)->playlists()->where('id', $id)->first();
        if ($playlist == null) {
            return $this->errorResponse("DATA_NOT_FOUND", 200);
        }
        $playlist->name = $request->name;
        $playlist->save();

        return $this->successResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $authID = auth('api')->id();
        $user = User::find($authID);

        $user->playlists()->where('id', $id)->delete();

        return $this->successResponse();
    }

    /**
     * Remove video from playlist
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function removeVideo(Request $request, $id)
    {
        $authID = auth('api')->id();
        $playlist = User::find($authID)->playlists()->where('id', $id)->first();

        $playlist->videos()->detach($request->video_id);

        return $this->successResponse();
    }

    /* WATCHLATER */
    /**
     * Display a watch later videos
     *
     * @return JsonResponse
     */
    public function watchLater()
    {
        $authID = auth('api')->id();
        $videos = User::find($authID)->videos()->get();

        $videoArray = array();
        foreach ($videos as $video) {
            $video->channel;
            $video->channel->is_followed = Channel::find($video["channel"]["id"])->followers->contains($authID);;
            $video->category;
            $video->subcategory;
            $video->labels;
            $video->views = $video->views()->count();

            array_push($videoArray, $video);
        }

        return $this->successResponseWithData($videoArray);
    }

    /**
     * Add video to watch later
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addLater(Request $request)
    {
        $authID = auth('api')->id();
        $user = User::find($authID);

        if (!$user->videos->contains($request->video_id)) {
            $user->videos()->attach($request->video_id);
        }

        return $this->successResponse();
    }

    /**
     * Remove video from watch later
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function removeLater(Request $request)
    {
        $authID = auth('api')->id();
        $user = User::find($authID);

        $user->videos()->detach($request->video_id);

        return $this->successResponse();
    }
}
