<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth.api:api');
    }

    /**
     * Display a list of articles
     *
     * @return Factory|View
     */
    public function index($categoryId)
    {
        $category = ArticleCategory::find($categoryId);
        dd($category);

        return view('article.index', ['articles' => $category->articles()->get(), 'categoryName' => $category->name]);
    }

    /**
     * Display the specific Article.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $article = Article::find($id);

        return $this->successResponseWithData($article);
    }
}
