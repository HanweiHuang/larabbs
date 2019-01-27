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

        return view('gallery.index', compact('folders'));
    }


    public function show(Request $request, $folder){

        $folders = Folder::all()->pluck('name')->toArray();

        if(in_array($folder, $folders)){
            $disk = $this->getStorageObj('qiniu');
            $files = $disk->allFiles($folder);
            $f_urls = $this->getFilesUrls($files);
            return view('gallery.show', compact('files','f_urls'));
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