<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostHtmlResource;
use App\Http\Resources\PostDetailResource;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostController extends Controller
{
    use SoftDeletes;

    public function indexView()
    {
        $posts = json_decode(Http::get('http://localhost/BreezeShop/public/api/posts'));
        // dd($posts->data);
        $posts = $posts->data;
        $title = 'posts';
        return view('dashboard', compact('posts', 'title'));
    }

    public function index()
    {
        $posts = Post::all();
        return PostDetailResource::collection($posts->loadMissing('writer:id,name'));
    }

    public function show($id)
    {
        $post = Post::with('writer:id,name')->findOrFail($id);
        return new PostDetailResource($post->loadMissing(['writer:id,name', 'comments:id,post_id,user_id,comments_content']));
    }

    public function showView($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function show2($id)
    {
        $post = Post::findOrFail($id);
        return new PostDetailResource($post);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $image = null;
        if ($request->file) {
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();
            $image = $fileName . '.' . $extension;

            Storage::putFileAs('image', $request->file, $image);
        }

        $request['image'] = $image;
        $request['author'] = Auth::user()->id;

        $post = Post::create($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,name'));
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,name'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return new PostDetailResource($post->loadMissing('writer:id,name'));
    }

    function generateRandomString($length = 30)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function showCreateForm()
    {
        return view('posts.create');
    }

    public function showEditForm($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }
}
