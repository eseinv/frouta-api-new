<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function showAllArticles()
    {
        $articles = Article::all();
        //  $articles->images = $articless->load('images');
        return response($articles, 200);
    }

    public function showArticle($id)
    {
        $article = Article::find($id);
        //  $article->images = $article->load('images');
        return response($article, 200);
    }

    public function createArticle(Request $request)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            $article = new Article;
            $article->name = $request['name'];
            $article->text = $request['text'];
            $article->image = $request['image'];
            $article->save();
            return response()->json(['Success' => 'Article was created'], 201);
        }
        return response()->json(['error'=> 'Not authorized']);
    }

    public function updateArticle(Request $request, $id)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            $article = Article::findOrFail($id);
            $article->update($request->all());
            return response()->json($article, 200);
        }
    }

    public function deleteArticle(Request $request, $id)
    {
        $type = $request->auth->type;
        if ($type == 'admin') {
            Article::findOrFail($id)->delete();
            return response(['success'=>'Deleted successfully'], 200);
        }
    }
}
