<?php

namespace App\Http\Controllers;

use App\Insight;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class InsightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('insight.index', ['insights' => Insight::paginate(10), 'menu' => 'insight']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function show($id)
    {
        return view('insight.show', ['insight' => Insight::find($id), 'menu' => 'insight']);
    }
}
