<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Label;
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
        $videos = Label::find($labelId)->videos()->get();

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
