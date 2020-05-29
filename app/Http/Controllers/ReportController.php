<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Report;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
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
        $filterBy = "unsolved";

        if ($request->has('filterBy')) $filterBy = $request->query('filterBy');

        $result = Report::search($filterBy)->paginate(10);

        return view('report.index', [
            'admin' => Auth::user(),
            'reports' => $result,
            'filterBy' => $filterBy,
            'menu' => 'report'
        ]);
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

    /**
     * Verify report.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function verify($id)
    {
        $report = Report::find($id);
        $report->is_solved = true;
        $report->save();

        return redirect()->route('admin.reports.all');
    }
}
