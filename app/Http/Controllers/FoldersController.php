<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;

use App\Models\Folder;

use Auth;


class FoldersController extends Controller{

    private function getStorageObj($name = 'qiniu'){
        return $disk = \Storage::disk($name);
    }

    public function __construct()
    {
        //auth can see these folders
        $this->middleware('auth');
    }

    //get all folders
    public function index(Request $request, Folder $folder)
    {
        $folders = Folder::all();
        foreach($folders as $folder){
            $files_size = sizeof(json_decode($folder->data));
            $folder->setAttribute('files_size', $files_size);
        }

        return view('gallery.index', compact('folders'));
    }

    public function show(Request $request, $folder){

        $folders = Folder::all()->pluck('name')->toArray();

        if(in_array($folder, $folders)){
            $disk = $this->getStorageObj('qiniu');
            $files = $disk->allFiles($folder);
            $f_urls = $this->getFilesUrls($files);
            //json
            $j_f_urls = json_encode($f_urls);
            //save to database
            $obj_folder = Folder::where('name', $folder)->first();
            $obj_folder->data = $j_f_urls;
            $obj_folder->save();

            return view('gallery.show', compact('files','f_urls','folder'));
        }
    }

    private function getFilesUrls(array $files){
        if(empty($files)) return $files;

        $disk = $this->getStorageObj('qiniu');
        $r_files = [];
        foreach ($files as $key => $value) {
            $v = $disk->url($value);
            $r_files[$key] = $v;
        }
        return $r_files;
    }


}


//