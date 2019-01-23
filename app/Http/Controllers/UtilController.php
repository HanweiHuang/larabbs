<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilController extends Controller
{

    public function switchLanguage(Request $request, $lang){
        // $referer = $request->server('HTTP_REFERER');

        // if(empty($referer)) $referer = url('/');

        // $langs = config('global.lang');
        // if(!empty($lang) && in_array($lang, $langs)){
        //     app()->setLocale($lang);
        //     app()->getLocale();
        //     //dd(app()->getLocale());
        // }

        // return redirect()->to($referer);
        if (in_array($lang, config('global.lang'))) {
            session(['applocale' => $lang]);
        }
        return back()->withInput();

    }
}