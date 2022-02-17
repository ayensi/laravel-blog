<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Repository\Repository;
use App\Models\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request,Repository $repo){
        $articles = $this->articleSearching($request->article_search);
        $articlesTop = $repo->sortArticlesByRating()->get(3);
        return view('blog.home',compact('articles','articlesTop'));
    }
    public function articleSearching($keyword){
        if($keyword){
            $articles = Article::search($keyword)
                ->paginate(8);
        }else{
            $articles = Article::paginate(8);
        }
        return $articles;
    }
}
