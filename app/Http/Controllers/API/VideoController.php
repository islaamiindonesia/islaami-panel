<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
        $now = Carbon::now()->toDateTimeString();

        $videos = Video::where('published_at', '<=', $now)->orderBy('published_at', 'desc')->get();

        $videoArray = array();
        foreach ($videos as $video) {
            $video->channel;
            $video->category;
            $video->subcategory;
            $video->labels;
            $video->views = $video->views()->count();

            array_push($videoArray, $video);
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
        return $this->successResponseWithData(Video::find($id));
    }
}
