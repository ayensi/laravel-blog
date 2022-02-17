<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Repository\Repository;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Rating;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BlogController extends Controller
{

    public function index(Request $request,Repository $repo){
        $articlesTop = $repo->sortArticlesByRating()->get(3);

        $articles = $repo->sortArticlesByRating()->paginate(8);
        return view('blog.home',compact('articles','articlesTop'));
    }
    public function article(Request $request){
        $article = Article::find($request->article_id);
//      $comments = Comment::where('article_id',$request->article_id)->orderBy('created_at','DESC')->get();
        $comments = Article::find($request->article_id)->comment->sortByDesc('likes');
        $replies = [];
        $i=0;
        foreach ($comments as $comment){
            $reply = Comment::find($comment->id)->reply->all();
            if($reply){
                foreach ($reply as $r){
                    $replies[$i] = $r;
                    $i+=1;
                }
            }

        }



//        $replies = Reply::where('comment_id',$comments->id)->get();


        return view('blog.article',compact('article','comments','replies'));
    }
    public function blogsFiltered(Request $request){
        $articles = Category::with('articles')->find($request->id)->articles;

        return view('blog.articles_filtered',compact('articles'));
    }
    public function rateArticle(Request $request){
        $article = Article::find($request->article_id);
        Rating::updateOrCreate(
            ['article_id' => $request->article_id, 'user_id' => auth()->id()],
            ['rating' => $request->rating]
        );
        return redirect()->back()->with(compact('article'));
    }
    public function likeComment(Request $request){
        $article = Article::find($request->article_id);
        $comment = Comment::find($request->id);
        if($comment->user_id==auth()->id()){
            return redirect()->back()->with('likeMessage','You can not like your own comment.')->with(compact('article'));
        }
        $likes = Like::where('comment_id',$request->id)
        ->where('user_id',auth()->id())->first();
        if(!$likes){
            $comment->likes +=1;
            $comment->save();

            $likes = new Like();
            $likes->comment_id =$request->id;
            $likes->user_id =auth()->id();
            $likes->save();
        }
        else{
            $likes->delete();
            $comment->likes -=1;
            $comment->save();
        }
        return redirect()->back()->with(compact('article'));
    }
    public function replyComment(Request $request){
        $article = Article::find($request->article_id);
        $comment = Comment::find($request->id);
        $reply = Reply::create([
            'reply' =>$request->reply,
            'comment_id' =>$request->id,
            'user_id' => auth()->id()
        ]);
        $comment->reply()->save($reply);

        return redirect()->back()->with(compact('article'));
    }
    public function makeComment(Request $request){
        $article = Article::find($request->id);
        $comment = Comment::create([
            'comment' =>$request->comment,
            'article_id' =>$request->id,
            'user_id' => auth()->id(),
            'likes' => 0
        ]);
        $comment->save();
        return redirect()->back()->with(compact('article'));
    }






}
