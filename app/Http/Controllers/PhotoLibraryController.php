<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoLibraryController extends Controller{

    public function index(Request $request){

        return view('gallery.index');

    }

}