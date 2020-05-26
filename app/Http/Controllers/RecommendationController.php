<?php

namespace App\Http\Controllers;

use App\Recommedation;
use Illuminate\Contracts\View\Factory;
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
        $recommendations = Recommedation::orderBy('created_at', 'desc')->paginate(10);

        return view('recommendation.index', [
            'recommendations' => $recommendations,
            'parent' => 'playmi',
            'menu' => 'recommendation'
        ]);
    }
}
