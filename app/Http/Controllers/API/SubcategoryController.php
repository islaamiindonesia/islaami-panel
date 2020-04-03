<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Subcategory;
use App\Video;
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
        $videos = Video::where('category_id', $categoryId)->where('subcategory_id', $subcategoryId)->get();

        $videoArray = array();
        foreach ($videos as $video) {
            $video->channel;
            $video->category;
            $video->subcategory;
            $video->labels;

            array_push($videoArray, $video);
        }

        return $this->successResponseWithData($videoArray);
    }
}
