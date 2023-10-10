<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    function welcome(){
        return view('welcome');
    }
    function store(Request $request){
        // $temp_file=Upload::where('folder',$request->image)->first();
        // if($temp_file){
        //     Storage::copy('post/temp/'.$temp_file->folder.'/'.$temp_file->filename);
        //     Post::create([
        //         'name'=>$request->name,
        //         'image'=>$temp_file->folder.'/'.$temp_file->filename,
        //     ]);
        // }
        $temp_file = Upload::where('folder', $request->image)->first();
        $sourcePath = 'post/temp/' . $temp_file->folder . '/' . $temp_file->filename;
        $destinationPath = 'new/destination/path/' . $temp_file->filename;
        // Define your destination path here
        Storage::copy($sourcePath, $destinationPath);

        // Create a new Post record
        Post::create([
            'name' => $request->name,
            'image' => $temp_file->folder . '/' . $temp_file->filename,
        ]);


    }
    function tempupload(Request $request){
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $folder = uniqid('post',true);



            $image->storeAs('post/temp/' . $folder , $filename);
            Upload::create([
                'folder'=>$folder,
                'filename'=>$filename,
            ]);
            return $folder;
        }
        return '';

    }
    function tempdelete(Request $request){
        $upload = Upload::where('folder', $request->getContent())->first();

        Storage::deleteDirectory('post/temp/' . $upload->folder);
        $upload->delete();

        return response('');

    }
}
