<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
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
        $report = new Report();
        $report->user_id = $authID;
        $report->description = $request->description;
        $report->image_url = $request->image_url;
        $report->save();

        return $this->successResponseWithData($report);
    }
}
