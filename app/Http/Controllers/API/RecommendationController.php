<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Recommedation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth.api:api');
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
        $insight = new Recommedation();
        $insight->user_id = $authID;
        $insight->channel_name = $request->channel_name;
        $insight->channel_url = $request->channel_url;
        $insight->save();

        return $this->successResponseWithData($insight);
    }
}
