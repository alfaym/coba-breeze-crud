<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index() {
        // return view ('article.index') and get data from Article's model using get()
        return view('article.index', [
            'articles' => Article::get(),
        ]);
    }

    // make public function create that return view article.form 
    public function create() {
        return view('article.form');
    }

    public function store(Request $request) {
        $inputs = $request->only('title', 'description');
        $create = Article::create($inputs);

        if ($create) {
            session()->flash('notif.success', 'Article created successfully!');
            return redirect()->route('article.index');
        }

        return abort(500);

        // $request->validate([
        //     'title' => 'required',
        //     'body' => 'required',
        // ]);
        // Article::create($request->all());
        // return redirect('/article');
    }

    public function edit($id) {
        $article  = Article::find($id);
        return view('article.form', [
            'article' => $article,
        ]);

        // $article = Article::find($id);
        // return view('article.form', compact('article'));
    }

    // make public function update that have request and id and return view article.form
    public function update(Request $request, $id) {
        $inputs = $request->only('title', 'description');
        $article = Article::find($id);
        $update = $article->update($inputs);

        if ($update) {
            return redirect()->route('article.index');
        }

        return abort(500);
    }

    // make public function destroy that have id and return view article.index
    public function destroy($id) {
        $article = Article::find($id);
        $delete = $article->delete();
        if ($delete) {
            return redirect()->route('article.index');
        }

        return abort(500);
    }
}
