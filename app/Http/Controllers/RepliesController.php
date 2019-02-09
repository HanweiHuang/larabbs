<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function store(ReplyRequest $request, Reply $reply)
	{
	    $reply->content = $request->content;
	    $reply->user_id = Auth::id();
	    $reply->topic_id = $request->topic_id;
	    $reply->save();
		return redirect()->to($reply->topic->link())->with('message', 'Created successfully.');
	}

	public function destroy(Reply $reply)
	{
        //distribute authority to reply
		$this->authorize('destroy', $reply);
		$reply->delete();
        //model reply has a function topic and topic has a function link, link will run a route
        //so actually here, the link is a route
        return redirect()->to($reply->topic->link())->with('message', 'Deleted successfully.');
		//return redirect()->route('replies.index')->with('message', 'Deleted successfully.');
	}

	public function index(){
        return abort(404);
    }

}