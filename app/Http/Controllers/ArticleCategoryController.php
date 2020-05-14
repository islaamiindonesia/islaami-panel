<?php

namespace App\Http\Controllers;

use App\ArticleCategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('article_category.index', ['admin' => Auth::user(), 'categories' => ArticleCategory::all(), 'menu' => 'article']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('article_category.create', ['admin' => Auth::user(), 'menu' => 'article']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $category = new ArticleCategory();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('admin.articleCategories.all');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $category = ArticleCategory::find($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('admin.articleCategories.all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return bool
     */
    public function destroy($id)
    {
        ArticleCategory::destroy($id);

        return true;
    }
}
