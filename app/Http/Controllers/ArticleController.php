<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleCategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $categoryId
     * @return Factory|View
     */
    public function index($categoryId)
    {
        $category = ArticleCategory::find($categoryId);
        return view('article.index', [
            'articles' => Article::where('category_id', $categoryId)->get(),
            'categoryName' => $category->name,
            'categoryID' => $category->id,
            'menu' => 'article'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create($categoryId)
    {
        return view('article.create', ['categoryID' => $categoryId, 'menu' => 'article']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request, $categoryId)
    {
        Article::firstOrCreate(
            ['title' => $request->title, 'category_id' => $categoryId],
            ['content' => $request->articleContent]
        );

        return redirect()->route('admin.articleCategories.articles.all', ['categoryId' => $categoryId]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function show($categoryId, $id)
    {
        return view('article.show', ['article' => Article::find($id), 'categoryID' => $categoryId, 'menu' => 'article']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($categoryId, $id)
    {
        return view('article.edit', ['article' => Article::find($id), 'categoryID' => $categoryId, 'menu' => 'article']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $categoryId, $id)
    {
        Article::updateOrCreate(
            ['id' => $id],
            ['title' => $request->title, 'content' => $request->articleContent]
        );

        return redirect()->route('admin.articleCategories.articles.all', ['categoryId' => $categoryId]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $categoryId
     * @param int $id
     * @return bool
     */
    public function destroy($categoryId, $id)
    {
        Article::where('id', $id)->where('category_id', $categoryId)->delete();

        return true;
    }
}
