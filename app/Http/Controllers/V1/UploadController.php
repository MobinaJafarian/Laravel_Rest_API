<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index(){
        //return view('upload');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|file|mimes:jpg,png',
        ]);

        $nameFile = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $nameFile);

        $main_path_file = asset('images/' . $nameFile);

        return response()->json([
            'data' => [
                'image' => $nameFile,
                'url' => $main_path_file,
                'status' => 'success',
            ],
        ]);
    }
}
