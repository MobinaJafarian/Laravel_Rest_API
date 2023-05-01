<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'min:3|max:50|string|unique:articles,title|required',
            'body' => 'min:5|max:500|string|required',
            'viewCount' => 'numeric|required|min:2',
        ]);

        Article::query()->create([
            'title' => $request->title,
            'body' => $request->body,
            'viewCount' => $request->viewCount,
        ]);

        return response()->json([
            'data' => [
                'message' => 'Article Created Sucessfully',
            ],
        ]);
    }
}
