<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\User;
use App\Post;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $page = null)
    {
        $auth = auth()->user();

        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        if(! $page) {
            $page = 'portfolio';
        }

        // contact categories
        $categories = Category::all();

        return view('home', compact('page', 'categories'));

    }
}
