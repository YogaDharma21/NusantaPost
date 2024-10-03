<?php

namespace App\Http\Controllers;

use App\Models\ArticleNews;
use App\Models\Author;
use App\Models\BannerAdvertisment;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
  public function index()
  {
    $categories = Category::all();

    $articles = ArticleNews::with(['category'])
      ->where('is_featured', 'not_featured')
      ->latest()
      ->take(3)
      ->get();

    $featured_articles = ArticleNews::with(['category'])
      ->where('is_featured', 'featured')
      ->inRandomOrder()
      ->take(3)
      ->get();

    $authors = Author::all();

    $bannerads = BannerAdvertisment::where('is_active','active')
    ->where('type','banner')
    ->inRandomOrder()
    // ->take(1)
    ->first();

    $automotive_articles = ArticleNews::whereHas('category',function($query){
      $query->where('name','Automotive');
    })
    ->where('is_featured','not_featured')
    ->latest()
    ->take(6)
    ->get();

    $automotive_featured_articles = ArticleNews::whereHas('category',function($query){
      $query->where('name','Automotive');
    })
    ->where('is_featured','featured')
    ->inRandomOrder()
    ->first();

    $business_articles = ArticleNews::whereHas('category',function($query){
      $query->where('name','Business');
    })
    ->where('is_featured','not_featured')
    ->latest()
    ->take(6)
    ->get();

    $business_featured_articles = ArticleNews::whereHas('category',function($query){
      $query->where('name','Business');
    })
    ->where('is_featured','featured')
    ->inRandomOrder()
    ->first();

    $entertainment_articles = ArticleNews::whereHas('category',function($query){
      $query->where('name','Entertainment');
    })
    ->where('is_featured','not_featured')
    ->latest()
    ->take(6)
    ->get();

    $entertainment_featured_articles = ArticleNews::whereHas('category',function($query){
      $query->where('name','Entertainment');
    })
    ->where('is_featured','featured') 
    ->inRandomOrder()
    ->first();

    return view('front.index', compact('categories', 'articles', 'authors','featured_articles','bannerads','automotive_articles','automotive_featured_articles','business_articles','business_featured_articles','entertainment_articles','entertainment_featured_articles'));
  }
  
  public function category(Category $category){
    $categories = Category::all();
    $bannerads = BannerAdvertisment::where('is_active','active')
    ->where('type','banner')
    ->inRandomOrder()
    ->first();
    return view('front.category',compact('category','categories','bannerads'));
  }

  public function author(Author $author){
    $categories = Category::all();
    $bannerads = BannerAdvertisment::where('is_active','active')
    ->where('type','banner')
    ->inRandomOrder()
    ->first();
    
    return view('front.author',compact('categories','author','bannerads'));
  }

  public function search(Request $request){
    $request->validate([
      'keyword'=>['required','string','max:255']
    ]);
    $categories = Category::all();
    $keyword = $request->keyword;
    $article = ArticleNews::with(['category','author'])
    ->where('name','LIKE','%'.$keyword.'%')->paginate(6);
    return view('front.search',compact('article','keyword','categories'));
  }

  public function details(ArticleNews $articleNews){
    $categories = Category::all();

    $articles = ArticleNews::with(['category'])
    ->where('is_featured', 'not_featured')
    ->where('id','!=', $articleNews->id)
    ->inRandomOrder()
    ->take(3)
    ->get();

    $bannerads = BannerAdvertisment::where('is_active','active')
    ->where('type','banner')
    ->inRandomOrder()
    ->first();

    $squareads = BannerAdvertisment::where('is_active','active')
    ->where('type','square')
    ->inRandomOrder()
    ->take(2)
    ->get();

    if($squareads->count() < 2){
      $squareads1 = $squareads->first();
      $squareads2 = $squareads->first();
    }else{
      $squareads1 = $squareads->get(0);
      $squareads2 = $squareads->get(1);
    }

    $authorArticle = ArticleNews::where('author_id',$articleNews->author_id)
    ->where('id','!=',$articleNews->id)
    ->inRandomOrder()
    ->take(3)
    ->get();

    return view('front.details',compact('authorArticle','squareads1','squareads2','articleNews','categories','articles','bannerads'));
  }
}
