<?php

namespace App\Http\Controllers\API;

use App\Channel;
use App\Http\Controllers\Controller;
use App\Label;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $subcategoryId
     * @return JsonResponse
     */
    public function index($categoryId, $subcategoryId)
    {
        $labels = Label::where('subcategory_id', $subcategoryId)->get();

        return $this->successResponseWithData($labels);
    }

    /**
     * Display video listing based on category.
     *
     * @return JsonResponse
     */
    public function videoLabel($categoryId, $subcategoryId, $labelId)
    {
        $authID = auth('api')->id();
        $now = Carbon::now()->toDateTimeString();

        $videos = Label::find($labelId)->videos()
            ->withCount('views as views')
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
            ->where('is_published', true)
            ->where('published_at', '<=', $now)
            ->where('category_id', $categoryId)
            ->where('subcategory_id', $subcategoryId)
            ->inRandomOrder()
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
     * Display video listing based on category.
     *
     * @return JsonResponse
     */
    public function videos($labelId)
    {
        $authID = auth('api')->id();
        $now = Carbon::now()->toDateTimeString();

        $videos = Label::find($labelId)->videos()
            ->withCount('views as views')
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
            ->where('is_published', true)
            ->where('published_at', '<=', $now)
            ->inRandomOrder()
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
}
