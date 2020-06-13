<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $query = null; // search query

        if ($request->has('query')) $query = $request->query('query');

        $categories = Category::search($query)->orderBy('number')->paginate(10);

        return view('category.index', [
            'categories' => $categories,
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
    public function create()
    {
        return view('category.create', ['numberStatus' => true, 'parent' => 'playmi', 'menu' => 'category']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $lastInputNumber = Category::max('number');

        Category::firstOrCreate(
            ['name' => $request->name],
            ['number' => ($lastInputNumber + 1)]
        );

        return redirect()->route('admin.categories.all');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $categoryId
     * @return Factory|View
     */
    public function edit($categoryId)
    {
        $category = Category::find($categoryId);

        return view('category.edit', ["category" => $category, 'parent' => 'playmi', 'menu' => 'category']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $categoryId
     * @return RedirectResponse
     */
    public function update(Request $request, $categoryId)
    {
        Category::updateOrCreate(
            ['id' => $categoryId],
            ['name' => $request->name]
        );

        return redirect()->route('admin.categories.all');
    }

    /**
     * Update the specified category number
     *
     * @param Request $request
     * @param int $categoryId
     * @return bool
     */
    public function updateNumber(Request $request, $categoryId)
    {
        Category::updateOrCreate(
            ['id' => $categoryId],
            ['number' => $request->number]
        );

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $categoryId
     * @return RedirectResponse
     */
    public function destroy($categoryId)
    {
        Category::destroy($categoryId);

        $this->rearrange();

        return redirect()->route('admin.categories.all');
    }

    // Re-arrange categories item
    private function rearrange()
    {
        $categories = Category::all();
        for ($i = 0; $i < $categories->count(); $i++) {
            $position = ($i + 1);

            Category::updateOrCreate(
                ['id' => $categories[$i]->id],
                ['number' => $position]
            );
        }
    }
}
