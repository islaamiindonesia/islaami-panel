<?php

namespace App\Http\Controllers\API;

use App\Channel;
use App\Http\Controllers\Controller;
use App\Subcategory;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $categoryId
     * @return JsonResponse
     */
    public function index($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();

        return $this->successResponseWithData($subcategories);
    }

    /**
     * Display video listing based on subcategory.
     *
     * @return JsonResponse
     */
    public function videoSubcategory($categoryId, $subcategoryId)
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
}
