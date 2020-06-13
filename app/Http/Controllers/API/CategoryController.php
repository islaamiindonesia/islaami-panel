<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Channel;
use App\Http\Controllers\Controller;
use App\User;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth.api:api');
    }

    /**
     * Display a list of categories.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $categories = Category::orderBy('number', 'asc')->get();
        return $this->successResponseWithData($categories);
    }

    /**
     * Display video listing based on category.
     *
     * @return JsonResponse
     */
    public function videoCategory($categoryId)
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
            ->whereNotIn('channel_id', User::find($authID)->blacklistChannels->pluck('id'))
            ->where('published_at', '<=', $now)
            ->where('category_id', $categoryId);

        if ($categoryId != 5) {
            $videos->inRandomOrder();
        } else {
            $videos->orderBy('published_at', 'desc');
        }

        $videoArray = array();
        foreach ($videos->paginate(10)->toArray()["data"] as $video) {
            $video["is_saved_later"] = Video::find($video["id"])->users->contains($video["id"]);
            $video["channel"]["is_followed"] = Channel::find($video["channel"]["id"])->followers->contains($authID);
            array_push($videoArray, $video);
        }

        return $this->successResponseWithData($videoArray);
    }
}
