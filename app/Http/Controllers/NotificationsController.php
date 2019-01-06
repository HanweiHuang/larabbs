<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NotificationsController extends Controller
{

    public function __construct()
    {
        //must login first
        $this->middleware('auth');
    }

    public function index(){
        //get all user notifications
        $notifications = Auth::user()->notifications()->paginate(20);

        //mark notifications has read
        Auth::user()->markAsRead();

        return view('notifications.index', compact('notifications'));
    }
}