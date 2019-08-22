<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $input = ($request->all() == null ?  json_decode($request->getContent(), true) : $request->all() );

        Category::create($input);

        return response()->json(['message' => 'Success'], 200, [], JSON_PRETTY_PRINT);
    }
}
