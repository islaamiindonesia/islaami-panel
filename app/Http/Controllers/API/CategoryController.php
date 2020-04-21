<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use App\Video;
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
        $categories = Category::all();
        return $this->successResponseWithData($categories);
    }

    /**
     * Display video listing based on category.
     *
     * @return JsonResponse
     */
    public function videoCategory($categoryId)
    {
        $videos = Video::where('category_id', $categoryId)->get();

        $videoArray = array();
        foreach ($videos as $video) {
            $video->channel;
            $video->category;
            $video->subcategory;
            $video->labels;
            $video->views = $video->views()->count();
            $video->channel->followers = $video->channel->followers()->count();
            $video->channel->videos = $video->channel->videos()->count();

            array_push($videoArray, $video);
        }

        return $this->successResponseWithData($videoArray);
    }
}
