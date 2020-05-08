<?php

namespace App\Http\Controllers;

use App\Category;
use App\Subcategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $categoryId
     * @return Factory|View
     */
    public function index($categoryId)
    {
        $category = Category::find($categoryId);
        $subcategories = Subcategory::where('category_id', $categoryId)->orderBy('number')->get();

        return view('subcategory.index', ['subcategories' => $subcategories, 'category' => $category, 'parent' => 'playmi', 'menu' => 'category']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $categoryId
     * @return Factory|View
     */
    public function create($categoryId)
    {
        $categories = Category::all();

        return view('subcategory.create', ['categories' => $categories, 'categoryID' => $categoryId, 'parent' => 'playmi', 'menu' => 'category']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $categoryId
     * @return RedirectResponse
     */
    public function store(Request $request, $categoryId)
    {
        $lastInputNumber = Subcategory::where('category_id', $categoryId)->max('number');

        $subcategory = new Subcategory();
        $subcategory->name = $request->name;
        $subcategory->number = ($lastInputNumber + 1);
        $subcategory->category_id = $categoryId;
        $subcategory->save();

        return redirect()->route('admin.categories.subcategories.all', ['categoryId' => $categoryId]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $categoryId
     * @param $subcategoryId
     * @return Factory|View
     */
    public function edit($categoryId, $subcategoryId)
    {
        $categories = Category::all();

        $subcategory = Subcategory::where('id', $subcategoryId)->first();

        return view('subcategory.edit', ["categories" => $categories, 'categoryID' => $categoryId, "subcategory" => $subcategory, 'parent' => 'playmi', 'menu' => 'category']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $categoryId
     * @param $subcategoryId
     * @return RedirectResponse
     */
    public function update(Request $request, $categoryId, $subcategoryId)
    {
        Subcategory::updateOrCreate(
            ['id' => $subcategoryId],
            ['name' => $request->name, 'category_id' => $categoryId]
        );

        return redirect()->route('admin.categories.subcategories.all', ['categoryId' => $categoryId]);
    }

    /**
     * Update the specified category number
     *
     * @param Request $request
     * @param int $categoryId
     * @param $subcategoryId
     * @return bool
     */
    public function updateNumber(Request $request, $categoryId, $subcategoryId)
    {
        Subcategory::updateOrCreate(
            ['id' => $subcategoryId, 'category_id' => $categoryId],
            ['number' => $request->number]
        );

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $categoryId
     * @param $subcategoryId
     * @return RedirectResponse
     */
    public function destroy($categoryId, $subcategoryId)
    {
        Subcategory::destroy($subcategoryId);

        $this->rearrange($categoryId);

        return redirect()->route('admin.categories.subcategories.all', ['categoryId' => $categoryId]);
    }

    // Re-arrange categories item
    private function rearrange($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        $length = Subcategory::where('category_id', $categoryId)->count();
        for ($i = 0; $i < $length; $i++) {
            $position = ($i + 1);

            Subcategory::updateOrCreate(
                ['id' => $subcategories[$i]->id],
                ['number' => $position]
            );
        }
    }
}
