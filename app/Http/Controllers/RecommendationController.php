<?php

namespace App\Http\Controllers;

use App\Recommedation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecommendationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $recommendations = Recommedation::orderBy('created_at', 'desc')->get();

        return view('recommendation.index', ['recommendations' => $recommendations, 'parent' => 'playmi', 'menu' => 'recommendation']);
    }
}
