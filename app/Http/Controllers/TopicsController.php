<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
		$topics =  $topic->withOrder($request->order)->paginate();
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

    /**
     * jump to a create a topic page
     * create a topic
     */
	public function create(Topic $topic)
	{
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

    /**
     * @param TopicRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * save a topic
     */
	public function store(TopicRequest $request, Topic $topic)
	{
	    $topic->fill($request->all());
	    $topic->user_id = Auth::id();
	    $topic->save();
		//$topic = Topic::create($request->all());
		return redirect()->route('topics.show', $topic->id)->with('message', 'Created successfully.');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}

	public function uploadImage(Request $request, ImageUploadHandler $uploader){

	    $data = [
	        'success' => false,
            'msg' => 'upload failed',
            'file_path' => '',
        ];

	    if($file = $request->upload_file){
	        $result = $uploader->save($request->upload_file, 'topics', \Auth::id(),1024);

	        if($result){
	            $data['file_path'] = $result['path'];
	            $data['msg'] = 'upload success';
	            $data['success'] = true;
            }
        }
        return $data;
    }
}