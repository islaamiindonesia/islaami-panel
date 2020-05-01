<?php

use App\AppPolicy;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('about', function () {
    $policy = AppPolicy::find("ABOUT_PLAYMI");
    return view('onepage', ['title' => "Tentang Aplikasi", "content" => $policy->content]);
});

Route::get('cooperation', function () {
    $policy = AppPolicy::find("COOP_PLAYMI");
    return view('onepage', ['title' => "Kerjasama", "content" => $policy->content]);
});

Route::get('terms-and-condition', function () {
    $policy = AppPolicy::find("TNC_PLAYMI");
    return view('onepage', ['title' => "Ketentuan Pengguna", "content" => $policy->content]);
});

Route::get('privacy-policy', function () {
    $policy = AppPolicy::find("PRIVACY_PLAYMI");
    return view('onepage', ['title' => "Kebijakan Privasi", "content" => $policy->content]);
});

Route::group(['middleware' => ['guest']], function () {

    Route::get('', 'AuthController@show')->name('landingPage');

    Route::post('login', 'AuthController@login')->name('login');
});

Route::group(['middleware' => ['auth']], function () {

    /* ADMIN */
    Route::prefix("admin")->name('admin.')->group(function () {

        Route::get('', 'AdminController@index')->name('home');

        Route::get('logout', 'AuthController@logout')->name('attempt.logout');

        /* SUPER ADMIN */
        Route::group(['middleware' => ['isSuperAdmin']], function () {

            Route::get('manage', 'AdminController@manageAdmin')->name('manage');

            Route::get('create', 'AdminController@create')->name('create');

            Route::post('store', 'AdminController@store')->name('store');

            Route::post('{id}/delete', 'AdminController@destroy')->name('delete');

            /*Route::prefix("roles")->name('roles.')->group(function () {

                Route::get('create', 'RoleController@create')->name('create');

                Route::get('{id}/edit', 'RoleController@edit')->name('edit');

                Route::post('update', 'RoleController@update')->name('update');

                Route::get('manage', 'RoleController@index')->name('manage');

                Route::post('{id}/delete', 'RoleController@destroy')->name('delete');
            });*/
        });

        /* PLAYMI Related Routes */
        Route::group(['middleware' => ['isPlaymi']], function () {

            /* VIDEOS */
            Route::prefix("videos")->name('videos.')->group(function () {

                Route::get('', 'VideoController@index')->name('all');

                Route::get('create', 'VideoController@create')->name('create');

                Route::post('store', 'VideoController@store')->name('store');

                Route::get('{id}/edit', 'VideoController@edit')->name('edit');

                Route::put('{id}/update', 'VideoController@update')->name('update');

                Route::get('{id}/show', 'VideoController@show')->name('show');

                Route::post('{id}/delete', 'VideoController@destroy')->name('delete');
            });

            /* CHANNELS */
            Route::prefix("channels")->name('channels.')->group(function () {

                Route::get('', 'ChannelController@index')->name('all');

                Route::get('create', 'ChannelController@create')->name('create');

                Route::post('store', 'ChannelController@store')->name('store');

                Route::get('{id}/edit', 'ChannelController@edit')->name('edit');

                Route::put('{id}/update', 'ChannelController@update')->name('update');

                Route::patch('{id}/suspend', 'ChannelController@suspend')->name('suspend');

                Route::patch('{id}/activate', 'ChannelController@activate')->name('activate');

                Route::get('{id}/show', 'ChannelController@show')->name('show');

                Route::post('{id}/delete', 'ChannelController@destroy')->name('delete');
            });

            /* CATEGORIES, SUB, & LABELS */
            Route::prefix("categories")->name('categories.')->group(function () {

                Route::get('', 'CategoryController@index')->name('all');

                Route::get('create', 'CategoryController@create')->name('create');

                Route::post('store', 'CategoryController@store')->name('store');

                Route::get('{categoryId}/edit', 'CategoryController@edit')->name('edit');

                Route::put('{categoryId}/update', 'CategoryController@update')->name('update');

                Route::patch('{categoryId}/updatenumber', 'CategoryController@updateNumber')->name('updateNumber');

                Route::post('{categoryId}/delete', 'CategoryController@destroy')->name('delete');

                /* SUBCATEGORIES */
                Route::prefix("{categoryId}/subcategories")->name('subcategories.')->group(function () {

                    Route::get('', 'SubcategoryController@index')->name('all');

                    Route::get('create', 'SubcategoryController@create')->name('create');

                    Route::post('store', 'SubcategoryController@store')->name('store');

                    Route::get('{subcategoryId}/edit', 'SubcategoryController@edit')->name('edit');

                    Route::put('{subcategoryId}/update', 'SubcategoryController@update')->name('update');

                    Route::patch('{subcategoryId}/updatenumber', 'SubcategoryController@updateNumber')->name('updateNumber');

                    Route::post('{subcategoryId}/delete', 'SubcategoryController@destroy')->name('delete');

                    /* LABELS */
                    Route::prefix("{subcategoryId}/labels")->name('labels.')->group(function () {

                        Route::get('', 'LabelController@index')->name('all');

                        Route::get('create', 'LabelController@create')->name('create');

                        Route::post('store', 'LabelController@store')->name('store');

                        Route::get('{labelId}/edit', 'LabelController@edit')->name('edit');

                        Route::put('{labelId}/update', 'LabelController@update')->name('update');

                        Route::patch('{labelId}/updatenumber', 'LabelController@updateNumber')->name('updateNumber');

                        Route::post('{labelId}/delete', 'LabelController@destroy')->name('delete');
                    });
                });
            });

            /* RECOMMENDATION */
            Route::prefix("recommendations")->name('recommendations.')->group(function () {

                Route::get('', 'RecommendationController@index')->name('all');
            });
        });

        /* ISLAAMI Related Routes */
        Route::group(['middleware' => ['isIslaami']], function () {
            /* CALENDAR */
            /*Route::get('calendar', function () {
                return view('calendar.index');
            })->name('calendar');*/

            /* USERS */
            Route::prefix("users")->name('users.')->group(function () {

                Route::get('', 'UserController@index')->name('all');

                Route::patch('{id}/suspend', 'UserController@suspend')->name('suspend');

                Route::patch('{id}/unsuspend', 'UserController@unsuspend')->name('unsuspend');

                Route::patch('{id}/delete', 'UserController@softDelete')->name('delete');

                Route::patch('{id}/restore', 'UserController@restoreUser')->name('restore');
            });
        });

        /* PLAYMI & ISLAAMI Related Routes */
        Route::group(['middleware' => ['isPlaymi', 'isIslaami']], function () {
            Route::get('edit', 'AdminController@edit')->name('edit');

            Route::put('changepassword', 'AdminController@changePassword')->name('changePassword');

            /* ARTICLE CATEGORIES */
            Route::prefix("articlecategories")->name('articleCategories.')->group(function () {

                Route::get('', 'ArticleCategoryController@index')->name('all');

                Route::get('create', 'ArticleCategoryController@create')->name('create');

                Route::post('store', 'ArticleCategoryController@store')->name('store');

                Route::put('{id}/update', 'ArticleCategoryController@update')->name('update');

                Route::post('{id}/delete', 'ArticleCategoryController@destroy')->name('delete');

                /* ARTICLES */
                Route::prefix("{categoryId}/articles")->name('articles.')->group(function () {

                    Route::get('', 'ArticleController@index')->name('all');

                    Route::get('create', 'ArticleController@create')->name('create');

                    Route::post('store', 'ArticleController@store')->name('store');

                    Route::get('{id}/edit', 'ArticleController@edit')->name('edit');

                    Route::put('{id}/update', 'ArticleController@update')->name('update');

                    Route::get('{id}/show', 'ArticleController@show')->name('show');

                    Route::post('{id}/delete', 'ArticleController@destroy')->name('delete');
                });
            });

            /* REPORTS */
            Route::prefix("reports")->name('reports.')->group(function () {

                Route::get('', 'ReportController@index')->name('all');

                Route::get('{id}/show', 'ReportController@show')->name('show');

                Route::patch('{id}/verify', 'ReportController@verify')->name('verify');
            });

            /* INSIGHTS */
            Route::prefix("insights")->name('insights.')->group(function () {

                Route::get('', 'InsightController@index')->name('all');

                Route::get('{id}/show', 'InsightController@show')->name('show');
            });

            /* POLICIES */
            Route::get('aboutapp', 'ArticleController@about')->name('about');
            Route::patch('aboutapp/edit', 'ArticleController@editAbout')->name('editAbout');

            Route::get('cooperation', 'ArticleController@cooperation')->name('cooperation');
            Route::patch('cooperation/edit', 'ArticleController@editCoop')->name('editCoop');

            Route::get('usertnc', 'ArticleController@usertnc')->name('usertnc');
            Route::patch('usertnc/edit', 'ArticleController@editTNC')->name('editTNC');

            Route::get('privacy', 'ArticleController@privacy')->name('privacy');
            Route::patch('privacy/edit', 'ArticleController@editPrivacy')->name('editPrivacy');
        });
    });
});





