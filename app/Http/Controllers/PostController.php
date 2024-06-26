<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    const LOCAL_STORAGE_FOLDER = 'images';
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
    private function saveImage($request) {
        // $image = $request->file('image');
        // $imageName = time() . '.' . $image->extension();
        /**
         * this will store the image in the storage
         * the first parameter is the folder name (images)
         * the second parameter is the image name (time() is the current time)
         * the third parameter is the disk name (public)
         */
        // $image->storeAs(self::LOCAL_STORAGE_FOLDER, $imageName, 'public');
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path(self::LOCAL_STORAGE_FOLDER), $imageName);
        return $imageName;
    }
    private function deleteImage($image_name) {
        // this will delete the image from the storage
        // $image_path = storage_path('app/public/' . self::LOCAL_STORAGE_FOLDER . '/' . $image_name);
        $image_path = public_path(self::LOCAL_STORAGE_FOLDER.'/'.$image_name);
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    public function index()
    {
        $all_posts = $this->post->latest()->get();
        return view('posts.index')
            ->with('all_posts', $all_posts);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:1|max:50',
            'body' => 'required|min:1|max:1000',
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:1048'
        ]);

        $this->post->user_id = Auth::user()->id; // this is the user id of the user
        $this->post->title = $request->title; // this is the title of the post
        $this->post->body = $request->body; // this is the body of the post
        // $this->post->image = $this->saveImage($request); // this is the image of the post
        //'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->save(); // this will save the post

        return redirect()->route('index'); // this will redirect the user to the posts.index route
    }

    public function show($id)
    {
        $post = $this->post->find($id);
        return view('posts.show')
            ->with('post', $post);
    }

    public function edit($id)
    {
        $post = $this->post->findOrfail($id);

        if(Auth::user()->id !== $post->user_id) {
            return redirect()->route('index');
        }

        return view('posts.edit')
            ->with('post', $post);
    }

    public function update(Request $request, $id)
    {

        $request->validate( [ // this is the validation for the request
            'title' => 'required|min:1|max:50',
            'body' => 'required|min:1|max:1000',
            'image' => 'mimes:jpeg,png,jpg,gif|max:1048', // this is the validation for the image
        ] );

        $post = $this->post->findOrFail($id);
        $post->title = $request->title; // this is the title of the post
        $post->body = $request->body; // this is the body of the post

        if ($request->image) {
            // delete the old image
            // $this->deleteImage($post->image);
            // save the new image
            // $post->image = $this->saveImage($request); // this is the image of the post
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }

        $post->save(); // this will save the post

        return redirect()->route('post.show', $id); // this will redirect the user to the posts.show route
    }

    public function destroy($id)
    {
        $post = $this->post->findOrFail($id);

        if(Auth::user()->id !== $post->user_id) {
            return redirect()->route('index');
        }

        // $this->deleteImage($post->image);
        $post->delete();

        return redirect()->route('index');
    }
}
