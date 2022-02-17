<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use Auth;

class AdminController extends Controller
{
    /*---------Views---------*/
    public function dashboard(){
        return view('admin.dashboard');
    }
    public function categories(){
        $categories = Category::all();
        return view('admin.categories',compact('categories'));
    }
    public function articles(){
        $articles = Article::all();
        $categories = Category::all(['id', 'category_name']);
        return view('admin.articles',compact('articles','categories'));
    }
    public function userRatings(){
        return view('admin.users');
    }
    public function topComments(){
        return view('admin.topreviews');
    }
    public function settings(){
        return view('admin.settings');
    }
    /*---------End Views---------*/

    /*---------Auth---------*/
    public function loginIndex(){
    return view('admin.login');
}
    public function login(Request $request){

        $check = $request->all();

        if(Auth::guard('admin')->attempt(['email' => $check['email'],'password' => $check['password']])){
            return redirect()->route('admin.dashboard')->with('message','Successfully logged in');
        }
        else{
            return back()->with('error','Invalid email or password');
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
    /*---------End Auth---------*/

    /*---------Category---------*/
    public function newCategoryIndex(){

    return view('admin.category.new');
    }
    public function categoryStore(Request $request){
        $category = new Category();
        $category->category_name = $request->name;
        $category->save();
        return  redirect()->route('admin.categories')->with('message','Category created successfully');
    }
    public function categoryEdit(Request $request){
        return view('admin.category.edit')->with('id',$request->id);
    }
    public function categoryUpdate(Request $request){
        $category = Category::find($request->id);

        $category->category_name = $request->name;

        $category->save();
        return  redirect()->route('admin.categories')->with('message','Category edited successfully');
    }
    public function categoryDestroy(Request $request){
        $category = Category::find($request->id);
        $category->delete();
        return  redirect()->route('admin.categories')->with('message','Category deleted successfully');
    }
    /*---------End Category---------*/

    /*---------Article---------*/
    public function newArticleIndex(){
        $categories = Category::all(['id', 'category_name']);
        return view('admin.article.new',compact('categories'));
    }
    public function articleStore(Request $request){
        $article = new Article();
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads'), $imageName);

        $article->article_name = $request->name;
        $article->article_content= $request->articlecontent;
        $article->article_image = "/uploads/".$imageName;
        $article->category_id = $request->category;
        $article->save();
        return  redirect()->route('admin.articles')->with('message','Article created successfully');
    }
    public function articleEdit(Request $request){
        return view('admin.article.edit')->with('id',$request->id);
    }
    public function articleUpdate(Request $request){
        $category = Category::find($request->id);

        $category->category_name = $request->name;

        $category->save();
        return  redirect()->route('admin.articles')->with('message','Article edited successfully');
    }
    public function articleDestroy(Request $request){
        $article = Article::find($request->id);
        $article->delete();
        return  redirect()->route('admin.articles')->with('message','Article deleted successfully');
    }
    /*---------End Article---------*/

}
