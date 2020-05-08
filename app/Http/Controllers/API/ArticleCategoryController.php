<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->successResponseWithData(Article::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function getArticle($id)
    {
        return $this->successResponseWithData(Article::find($id));
    }

    /**
     * Display a list of article based on Category.
     *
     * @return JsonResponse
     */
    public function articleCategory($categoryId)
    {
        $articles = Article::where('category_id', $categoryId)->get();

        return $this->successResponseWithData($articles);
    }
}
