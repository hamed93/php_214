<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\ArticleRequest;
use App\Http\Controllers\Admin\ArticleConetrollr;
use Illuminate\Foundation\Auth\User;


class ArticleController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles=Article::latest()->paginate(20);
        return view ('admin.articles.all',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('admin.articles.create');
    }        //
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
      //auth()->loginUsingId(1);
       $imagesUrl= $this->uploadImages($request->file('images'));
       auth()->user()->article()->create(array_merge($request->all(),['images'=>$imagesUrl]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit',compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ArticleRequest  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request,Article $article)
    {
        $file=$request->file('images');
        $inputs=$request->all();
        if($file){
            $inputs=$this->uploadImages($request->file('images'));
        }
         else{
             $inputs['images']=$article->images;
             
         }
         $inputs['images']['thumb']=$inputs['imagesThumb'];
          unset($inputs['imagesThumb']);

          $article->update($inputs);
         
         
         return redirect(route('articles.index'));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect(route('articles.index'));
    }
}
