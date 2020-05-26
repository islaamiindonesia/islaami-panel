<?php

namespace App\Http\Controllers;

use App\Label;
use App\Subcategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $categoryId
     * @param $subcategoryId
     * @return Factory|View
     */
    public function index(Request $request, $categoryId, $subcategoryId)
    {
        $query = null; // search query

        if ($request->has('query')) $query = $request->query('query');

        $subcategory = Subcategory::find($subcategoryId);
        $labels = Label::search($query)
            ->where('subcategory_id', $subcategoryId)
            ->orderBy('number')
            ->paginate(10);

        return view('label.index', [
            'labels' => $labels,
            'categoryID' => $categoryId,
            'subcategoryID' => $subcategoryId,
            'subcategory' => $subcategory,
            'query' => $query,
            'parent' => 'playmi',
            'menu' => 'category'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create($categoryId, $subcategoryId)
    {
        $subcategories = Subcategory::all();

        return view('label.create', ['subcategories' => $subcategories, 'categoryID' => $categoryId, 'subcategoryID' => $subcategoryId, 'parent' => 'playmi', 'menu' => 'category']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request, $categoryId, $subcategoryId)
    {
        $lastInputNumber = Label::where('subcategory_id', $subcategoryId)->max('number');

        Label::firstOrCreate(
            ['name' => $request->name, 'subcategory_id' => $subcategoryId],
            ['number' => ($lastInputNumber + 1)]
        );

        return redirect()->route('admin.categories.subcategories.labels.all', ['categoryId' => $categoryId, 'subcategoryId' => $subcategoryId]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($categoryId, $subcategoryId, $labelId)
    {
        $label = Label::where('id', $labelId)->first();

        return view('label.edit', ["label" => $label, 'categoryID' => $categoryId, 'subcategoryID' => $subcategoryId, 'parent' => 'playmi', 'menu' => 'category']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $categoryId, $subcategoryId, $labelId)
    {
        Label::updateOrCreate(
            ['id' => $labelId],
            ['name' => $request->name]
        );

        return redirect()->route('admin.categories.subcategories.labels.all', ['categoryId' => $categoryId, 'subcategoryId' => $subcategoryId]);
    }

    /**
     * Update the specified category number
     *
     * @param Request $request
     * @param int $id
     * @return bool
     */
    public function updateNumber(Request $request, $categoryId, $subcategoryId, $labelId)
    {
        Label::updateOrCreate(
            ['id' => $labelId, 'subcategory_id' => $subcategoryId],
            ['number' => $request->number]
        );

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($categoryId, $subcategoryId, $labelId)
    {
        Label::destroy($labelId);

        $this->rearrange($subcategoryId);

        return redirect()->route('admin.categories.subcategories.labels.all', ['categoryId' => $categoryId, 'subcategoryId' => $subcategoryId]);
    }

    // Re-arrange categories item
    private function rearrange($subcategoryId)
    {
        $labels = Label::where('subcategory_id', $subcategoryId)->get();
        $length = Label::where('subcategory_id', $subcategoryId)->count();
        for ($i = 0; $i < $length; $i++) {
            $position = ($i + 1);

            Label::updateOrCreate(
                ['id' => $labels[$i]->id],
                ['number' => $position]
            );
        }
    }
}
