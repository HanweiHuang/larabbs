<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoLibraryController extends Controller{

    public function index(Request $request){

        $disk = \Storage::disk('qiniu');
        $v = $disk->url('20190126/UNADJUSTEDNONRAW_thumb_1249.jpg');

        return view('gallery.index', compact('v'));

    }

}