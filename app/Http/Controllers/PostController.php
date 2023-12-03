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
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\PostDetailResource;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostController extends Controller
{
    use SoftDeletes;

    public function indexView()
    {
        // dd($posts->data);
        $posts = json_decode(Http::get('http://localhost/BreezeShop/public/api/posts'));
        $posts = $posts->data;
        $title = 'posts';
        return view('dashboard', compact('posts', 'title'));
    }

    public function editView(Request $request, $id)
    {
        // $post = json_decode(Http::patch("http://localhost/BreezeShop/public/api/posts/{$id}"));
        // $post = $post->data;
        $response = Http::get("http://localhost/BreezeShop/public/api/posts/{$id}", $request->all());
        $post = json_decode($response->body())->data;
        return view('posts.edit', compact('post'));
    }

    public function deleteView(Request $request, $id)
    {
        $response = Http::get("http://localhost/BreezeShop/public/api/posts/{$id}", $request->all());
        $post = json_decode($response->body())->data;
        return view('posts.destroy', compact('post'));
    }

    public function newDestroy($id)
    {
        $post = Post::findOrFail($id);

        // Check if the authenticated user is the author of the post
        if (auth()->check() && $post->author == auth()->user()->id) {
            $post->delete();
            return Redirect::route('dashboard')->with('success', 'Post deleted successfully.');
        } else {
            // If the authenticated user is not the author, you can redirect with an error message
            return Redirect::route('dashboard')->with('error', 'You are not authorized to delete this post.');
        }
    }

    public function newUpdate($id, Request $request)
    {
        $validated = $request->validate([
            'title' => '',
            'news_content' => '',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        // Redirect to the edit view after updating
        return redirect()->route('post.show', ['id' => $post->id])->with('success', 'Post updated successfully.');
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
        // return Redirect::route('dashboard')->with('success', 'Post created successfully.');
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

    public function postCreateForm(Request $request)
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
        // return new PostDetailResource($post->loadMissing('writer:id,name'));
        return Redirect::route('dashboard')->with('success', 'Post created successfully.');
    }

    public function showEditForm($id)
{
    $post = Post::findOrFail($id);

    // Check if the post belongs to the authenticated user
    if ($post->author !== auth()->user()->id) {
        return Redirect::route('dashboard')->with('error', 'Post bukan milik anda.');
    }

    return view('posts.edit', compact('post'));
}
}
