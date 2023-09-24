<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    // public function index(){
    //                     //model
    //     $data = Article::all();
    //                     //view
    //     return view('articles.index', [
    //         'articles' => $data //just named $data
    //     ]);
    // }

    public function index(){
                // sort neweset  5 card per page
        // $data = Article::latest()->paginate(5);
        $data = Article::latest()->get();
        // $data = Article::all();
                        //view
        return view('articles.index', [
            'articles' => $data //just named $data
            // $articles->
        ]);
    }

    public function detail($id){
        $data = Article::find($id);//find posted id from data base!

        return view('articles.detail', [
            'article' => $data
        ]);
    }

    public function add(){

        $data = Category::all();

        return view('articles.add',[
            'categories' => $data,
        ]);
    }

    public function create(Request $request){
        // dd($request->all());
                                    // $getall
        $validator = validator($request->all(),[
            "title" => "required",
            "body" => "required",
            "category_id" => "required",
        ]);
        //step back to add with errors
        if($validator->fails()){
            // same as //return redirect("/articles/add")->withErrors($validator);
            return back()->withErrors($validator);
        }
        $img_name = '';
        if($request->hasFile('img')){
            $img_name = time(). '_'. $request->img->getClientOriginalName();
          $request->img->move(public_path('storage/images'), $img_name);
        //   dd($request->all());
        }

        $article = new Article;//Article from Model
        $article->title = $request->title; // like $_POST['title]
        $article->body = $request->body;
        $article->category_id = $request->category_id;
        $article->img = $img_name;
        $article->user_id = auth()->user()->id;
        $article->save();

        // if(isset($article->img)){
        //     return redirect("/articles")->with('info','erer');
        // }
        return redirect("/articles");
    }

    public function delete($id){
        $article = Article::find($id);
        if(Gate::allows('delete-article', $article)){
        $article->delete();
        return redirect("/articles")->with("feedback","delete selected article");
        }

        return back()->with('info', 'unauthorize to delete');
    }

    public function edit($id){
        $article = Article::find($id);

        if(Gate::allows('edit-article', $article)){
            $data2 =Category::all();
            return view('articles.edit',[
                'article'=> $article,
                'categories' => $data2,
            ]);
        }
        return redirect("/articles/detail/{$id}")->with("info","u can't edit other");
    }

    public function update($id) {
        $article = Article::find($id);

        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->save();

        return redirect("/articles/detail/{$id}")->with("info","edited as u wish!");
    }

    public function ballon($id)  {
        $article = Article::find($id);
        // $c = request()->count;
        $article->count = request()->final;
        $article->ballon = request()->icon;
        $article->save();
        // echo c;
        echo $article->ballon;
         echo $article->count;
        //  echo
        //  echo $article->user->name;

    }

}
