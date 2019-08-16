<?php

namespace App\Http\Controllers;

use Auth;
use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use App\Http\Requests\TopicRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class TopicsController extends Controller
{
    /**
     * TopicsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * @param Request $request
     * @param Topic $topic
     * @param User $user
     * @param Link $link
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function index(Request $request, Topic $topic, User $user, Link $link)
	{
		$topics =  $topic->withOrder($request->order)->paginate();
        $active_users = $user->getActiveUsers();
        $links = $link->getAllCached();
		return view('topics.index', compact('topics', 'active_users', 'links'));
	}

    /**
     * show single topic content, if url slug is not right the slug the topic has,
     * 301 redirect to right url
     */
    public function show(Topic $topic, Request $request)
    {
        if(!empty($topic->slug) && $topic->slug != $request->slug){
            return redirect($topic->link(), 301);
        }
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

		return redirect()->to($topic->link())->with('message', 'Created successfully.');
	}

    /**
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function edit(Topic $topic)
	{
	    try {
            $this->authorize('update', $topic);
            $categories = Category::all();
        }catch (AuthorizationException $e) {
            Log::info('TopicController.edit', ['exception' => $e]);
        }catch (\Exception $e) {
            Log::error('TopicController.edit', ['exception' => $e]);
        }

		return view('topics.create_and_edit', compact('topic','categories'));
	}

    /**
     * @param TopicRequest $request
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     */
	public function update(TopicRequest $request, Topic $topic)
	{
        try{
            $this->authorize('update', $topic);
            $topic->update($request->all());
        }catch (AuthorizationException $e) {
            Log::info('TopicController.update', ['exception' => $e]);
        }catch (\Exception $e) {
            Log::error('TopicController.update', ['exception' => $e]);
        }

		return redirect()->to($topic->link())->with('message', 'Updated successfully.');
	}

    /**
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
	public function destroy(Topic $topic)
	{
	    try{
            $this->authorize('destroy', $topic);
            $topic->delete();
        }catch (AuthorizationException $e) {
            Log::info('TopicController.destroy', ['exception' => $e]);
        }catch (\Exception $e) {
	        Log::error('TopicController.destroy', ['exception' => $e]);
        }

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}

    /**
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return array
     */
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