<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* PUBLIC ACCESS */
/* CATEGORY */
Route::prefix("categories")->group(function () {

    Route::get('', 'API\CategoryController@index')->name('allCategories');

    /* SUBCATEGORY */
    Route::prefix("{categoryId}/subcategories")->group(function () {

        Route::get('', 'API\SubcategoryController@index')->name('allSubcategories');

        /* LABEL */
        Route::prefix("{subcategoryId}/labels")->group(function () {

            Route::get('', 'API\LabelController@index')->name('allLabels');
        });
    });
});

Route::get('', function (Request $request) {
    return response()->json([
        'app' => config('app.name'),
        'version' => '1.0.0',
    ]);
});

Route::post('login', 'API\AuthController@login');

Route::post('register', 'API\AuthController@register');

Route::get('resend', 'API\AuthController@resendEmail');

Route::patch('verify', 'API\AuthController@verify');

Route::prefix("password")->group(function () {

    Route::post('forgot', 'API\AuthController@forgotPassword');

    Route::get('reset/{token}', 'API\AuthController@resetPassword');
});

Route::middleware('auth.api:api')->group(function () {

    /* CHANNEL */
    Route::prefix("channels")->group(function () {

        Route::get('', 'API\ChannelController@index');

        Route::get('{id}/videos', 'API\ChannelController@videosChannel');

        Route::get('follow', 'API\ChannelController@indexFollow');

        Route::get('blacklist', 'API\ChannelController@indexBlacklist');

        Route::get('{id}', 'API\ChannelController@show');

        Route::put('{id}/follow', 'API\ChannelController@follow');

        Route::put('{id}/unfollow', 'API\ChannelController@unfollow');

        Route::put('{id}/show', 'API\ChannelController@removeBlacklist');

        Route::put('{id}/hide', 'API\ChannelController@addBlacklist');
    });

    /* VIDEO */
    Route::prefix("videos")->group(function () {

        Route::get('', 'API\VideoController@index');

        Route::get('following', 'API\VideoController@indexFollowing');

        Route::get('{id}', 'API\VideoController@show');
    });

    /* USER */
    Route::prefix("user")->group(function () {

        Route::get('profile', 'API\UserController@getUser');

        Route::put('profile/update', 'API\UserController@update');

        Route::post('logout', 'API\AuthController@logout');

        Route::prefix("playlists")->group(function () {

            Route::get('', 'API\PlaylistController@index');

            Route::get('{id}', 'API\PlaylistController@show');

            Route::post('add', 'API\PlaylistController@store');

            Route::patch('{id}', 'API\PlaylistController@update');

            Route::delete('{id}', 'API\PlaylistController@destroy');

            Route::put('{id}/addvideo', 'API\PlaylistController@addVideo');

            Route::put('{id}/removevideo', 'API\PlaylistController@removeVideo');
        });

        Route::prefix("watchlater")->group(function () {

            Route::get('', 'API\PlaylistController@watchLater');

            Route::put('add', 'API\PlaylistController@addLater');

            Route::put('remove', 'API\PlaylistController@removeLater');
        });
    });

    /* ARTICLES */
    Route::prefix("articles")->group(function () {

        Route::get('', 'API\ArticleController@index');

        Route::get('{id}', 'API\ArticleController@show');

//        Route::get('category/{categoryId}', 'API\ArticleController@articleCategory');
    });

    /* CATEGORY */
    Route::prefix("categories")->group(function () {

        Route::get('{categoryId}/videos', 'API\CategoryController@videoCategory');

        /* SUBCATEGORY */
        Route::prefix("{categoryId}/subcategories")->group(function () {

            Route::get('{subcategoryId}/videos', 'API\SubcategoryController@videoSubcategory');

            /* LABEL */
            Route::prefix("{subcategoryId}/labels")->group(function () {

                Route::get('{labelId}/videos', 'API\LabelController@videoLabel');
            });
        });
    });

    /* REPORTS */
    Route::prefix("reports")->group(function () {

        Route::post('add', 'API\ReportController@store');
    });

    /* INSIGHTS */
    Route::prefix("insights")->group(function () {

        Route::post('add', 'API\InsightController@store');
    });

    /* RECOMMENDATION */
    Route::prefix("recommendations")->group(function () {

        Route::post('add', 'API\RecommendationController@store');
    });

    /* APP POLICY */
    Route::get('about', 'API\ArticleController@about');
    Route::get('cooperation', 'API\ArticleController@cooperation');
    Route::get('tnc', 'API\ArticleController@tnc');
    Route::get('privacy', 'API\ArticleController@privacy');
});
