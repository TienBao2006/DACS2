<?php

namespace App\Http\Controllers\Img;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function showForm()
    {
        $posts = DB::table('posts')->get(); 
        return view('img.updateimg', compact('posts')); 
    }

    public function upload(Request $request)
    {
        $title = $request->input('title');
        $content = $request->input('content');
        $path = null;
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('images', $fileName, 'public');
        }

        DB::table('posts')->insert([
            'image' => $path,
            'title' => $title,
            'content' => $content,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Image uploaded successfully')->with('path', $path);
    }
    public function Animation()
    {
        $posts = DB::table('posts')->first();
        return view('img.animation', compact('posts'));
    }
}
