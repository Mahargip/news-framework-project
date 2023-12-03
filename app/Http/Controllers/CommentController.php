<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;


class CommentController extends Controller
{
    use SoftDeletes;

    public function indexView(Request $request)
    {
        // // dd($posts->data);
        // $comments = json_decode(Http::post('http://localhost/BreezeShop/public/api/comments'));
        // // return dd($comments->data);
        // return redirect()->route('posts.show', ['id' => $comments->data->post_id]);

        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comments_content' => 'required',
        ]);

        $request['user_id'] = auth()->user()->id;

        $comment = Comment::create($request->all());
        return redirect()->route('post.show', ['id' => $validated['post_id']]);
    }

    public function index()
    {
        $comment = Comment::latest()->get();
        return response()->json(['data' => $comment]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comments_content' => 'required',
        ]);

        $request['user_id'] = auth()->user()->id;

        $comment = Comment::create($request->all());
        return new CommentResource($comment->loadMissing(['commentator:id,name']));
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'comments_content' => 'required',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($request->only('comments_content'));

        return new CommentResource($comment->loadMissing(['commentator:id,name']));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

    }

    public function showCreateForm(){
        return view('comments.create');
    }

    public function showEditForm($id)
    {
        $comment = Comment::findOrFail($id);
        return view('comments.edit', compact('comment'));
    }
}
