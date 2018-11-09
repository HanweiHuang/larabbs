<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct(){
        //auth all function except function show
        $this->middleware('auth',['except' => ['show']]);
    }

    //show all users
    public function show(User $user){
        return view('users.show', compact('user'));
    }

    //edit user send user info
    public function edit(User $user){
        $this->authorize('update',$user);
        return view('users.edit', compact('user'));
    }

    //update user after edit
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user){
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', 'Personal Info Update Successfully！');
    }


}
