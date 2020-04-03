<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $selected = "unsolved";
        $filter = $request->query('filter');
        if ($filter != null) {
            if ($filter == "solved") {
                $reports = Report::where('is_solved', true)->get();
            } else {
                $reports = Report::where('is_solved', false)->get();
            }
            $selected = $filter;
        } else {
            $reports = Report::where('is_solved', false)->get();
        }

        return view('report.index', ['admin' => Auth::user(), 'reports' => $reports, 'selected' => $selected, 'menu' => 'report']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function show($id)
    {
        $report = Report::find($id);

        return view('report.show', ['admin' => Auth::user(), 'report' => $report, 'menu' => 'category']);
    }
}
