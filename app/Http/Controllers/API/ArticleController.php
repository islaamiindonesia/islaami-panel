<?php

namespace App\Http\Controllers\API;

use App\AppPolicy;
use App\Article;
use App\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
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

    /* APP POLICY */
    public function about()
    {
        $policy = AppPolicy::find("ABOUT_PLAYMI");

        if ($policy != null) {
            return $this->successResponseWithData($policy);
        }

        return $this->successResponse();
    }

    public function cooperation()
    {
        $policy = AppPolicy::find("COOP_PLAYMI");

        if ($policy != null) {
            return $this->successResponseWithData($policy);
        }

        return $this->successResponse();
    }

    public function tnc()
    {
        $policy = AppPolicy::find("TNC_PLAYMI");

        if ($policy != null) {
            return $this->successResponseWithData($policy);
        }

        return $this->successResponse();
    }

    public function privacy()
    {
        $policy = AppPolicy::find("PRIVACY_PLAYMI");

        if ($policy != null) {
            return $this->successResponseWithData($policy);
        }

        return $this->successResponse();
    }
}
