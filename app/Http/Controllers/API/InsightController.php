<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Insight;
use App\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InsightController extends Controller
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
        $insight = new Insight();
        $insight->user_id = $authID;
        $insight->detail = $request->detail;
        $insight->save();

        return $this->successResponseWithData($insight);
    }
}
