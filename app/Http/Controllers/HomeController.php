<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Restaurant;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user(); // ログインユーザー取得
        
        // 商品一覧取得
        $restaurants = restaurant::orderBy('created_at', 'desc')->take(5)->get();

        return view('home', compact('restaurants', 'user'));
        //return view('home');
    }
}
