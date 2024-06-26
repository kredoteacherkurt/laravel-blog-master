<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    // save the file to app stoarge/public/avatars folder
    const LOCAL_STORAGE_FOLDER = 'avatars';

    private function saveAvatar($request){
        $avatar = time().'.'.$request->avatar->extension();

        $request->avatar->move(public_path(self::LOCAL_STORAGE_FOLDER), $avatar);
        return $avatar;
    }

    private function deleteAvatar($avatar){
        $avatar_path = public_path(self::LOCAL_STORAGE_FOLDER.'/'.$avatar);

        if(file_exists($avatar_path)){
            unlink($avatar_path);
        }
    }

    public function show()
    {
        $user = $this->user->findOrfail(Auth::user()->id);
        return view('users.show')->with('user', $user);
    }

    public function edit($id)
    {
        $user = $this->user->findOrfail($id);
        return view('users.edit')->with('user', $user);
    }

    public function update(Request $request)
    {
        //chck if the logged in user is the same as the user being updated
        if(Auth::user()->id != $request->id){
            return redirect()->route('profile.show');
        }

        $requestData = [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|max:50|'. Rule::unique('users')->ignore(Auth::user()->id),
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,gif|max:1048',
        ];

        $user = $this->user->findOrfail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->avatar) {
            if ($user->avatar) {
                $this->deleteAvatar($user->avatar);
            }
            $user->avatar = $this->saveAvatar($request);
            // $user->avatar  = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        $user->save();

        return redirect()->route('profile.show');
    }
}
