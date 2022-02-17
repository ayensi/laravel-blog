<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


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
/*-------------------- Admin Routes ---------------------*/
Route::get('/admin/login',[AdminController::class,'loginIndex'])->name('admin.loginIndex');
Route::post('/admin/login',[AdminController::class,'login'])->name('admin.login');
Route::prefix('/admin')->middleware('admin')->group(function(){

    /*------------- General Routes --------------*/

    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/categories',[AdminController::class,'categories'])->name('admin.categories');
    Route::get('/articles',[AdminController::class,'articles'])->name('admin.articles');
    Route::get('/topreviews',[AdminController::class,'topComments'])->name('admin.topComments');
    Route::get('/settings',[AdminController::class,'settings'])->name('admin.settings');
    Route::get('/users',[AdminController::class,'userRatings'])->name('admin.userRatings');
    Route::get('/logout',[AdminController::class,'logout'])->name('admin.logout');

    /*------------- End General Routes --------------*/

    /*------------- Category Routes --------------*/

    Route::get('/category/new',[AdminController::class,'newCategoryIndex'])->name('admin.newCategoryIndex');
    Route::post('/category/new',[AdminController::class,'categoryStore'])->name('admin.categoryStore');
    Route::get('/category/edit',[AdminController::class,'categoryEdit'])->name('admin.categoryEdit');
    Route::put('/category/edit',[AdminController::class, 'categoryUpdate'])->name('admin.categoryUpdate');
    Route::delete('/category/delete',[AdminController::class, 'categoryDestroy'])->name('admin.categoryDestroy');

    /*---------- End Category Routes --------------*/

    /*------------- Article Routes --------------*/

    Route::get('/article/new',[AdminController::class,'newArticleIndex'])->name('admin.newArticleIndex');
    Route::post('/article/new',[AdminController::class,'articleStore'])->name('admin.articleStore');
    Route::get('/article/edit',[AdminController::class,'articleEdit'])->name('admin.articleEdit');
    Route::put('/article/edit',[AdminController::class, 'articleUpdate'])->name('admin.articleUpdate');
    Route::delete('/article/delete',[AdminController::class, 'articleDestroy'])->name('admin.articleDestroy');

    /*---------- End Article Routes --------------*/

});

/*-------------------- End Admin Routes ---------------------*/

/*------------- Blog Routes --------------*/

Route::get('/',[BlogController::class,'index'])->name('index');
Route::get('/blogs',[BlogController::class,'blogsFiltered'])->name('blogs.filtered');
Route::get('/article',[BlogController::class,'article'])->name('article');
Route::post('/article/rate',[BlogController::class, 'rateArticle'])->name('article.rate')->middleware('auth');
Route::post('/article/comment',[BlogController::class, 'makeComment'])->name('article.comment')->middleware('auth');
Route::post('/article/likeComment',[BlogController::class, 'likeComment'])->name('article.likeComment')->middleware('auth');
Route::post('/article/replyComment',[BlogController::class, 'replyComment'])->name('article.replyComment')->middleware('auth');
Route::get('/blog/results',[SearchController::class,'index'])->name('searchedArticles');
/*---------- Blog Routes --------------*/


require __DIR__.'/auth.php';
