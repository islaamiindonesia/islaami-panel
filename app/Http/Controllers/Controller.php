<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $date
     * default input format is Y-m-d (2020-12-03)
     * @param string $inputFormat
     * default output format is d-m-Y (03-12-2020)
     * @param string $outputFormat
     * @return string
     */
    public function createCustomDate($date, $inputFormat = "Y-m-d", $outputFormat = "d-m-Y")
    {
        $date = Carbon::createFromFormat($inputFormat, $date);
        return $date->format($outputFormat);
    }

    public function successResponse()
    {
        return response()->json([
            'data' => [],
            'success' => true,
        ]);
    }

    public function successResponseWithData($data)
    {
        return response()->json([
            'data' => $data,
            'success' => true,
        ]);
    }

    public function errorResponse($message, $code = 401)
    {
        return response()->json([
            'data' => [],
            'success' => false,
            'message' => $message,
        ], $code);
    }

    public function errorResponseWithData($data, $message, $code = 401)
    {
        return response()->json([
            'data' => $data,
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
