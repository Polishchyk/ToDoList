<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Task;

class CommentController extends Controller
{
    public function index()
    {
        return new CommentCollection(Comment::where("parent_id", "=", null)->paginate());
    }

    public function store(StoreCommentRequest $request)
    {

        $request->validate([
            'body'=>'required',
        ]);

        $attr = $request->validated();

        $comment = new Comment();
        $comment->body = $attr['body'];
        $comment->parent_id = isset($attr['parent_id']) ? $attr['parent_id'] : null;
        $comment->user_id = $request->user()->id;
        $comment->task_id = $attr['task_id'];
        $comment->save();

        return new CommentResource($comment);
    }

    public function showByTaskId($taskId)
    {
        $task = Task::with(['comments'=> function($q){
            $q->where('parent_id', '=', null);
        }])->where('id', '=', $taskId)->paginate(15);

        return new CommentCollection($task);
    }

    public function show($id)
    {
        $comment = Comment::where('id', "=", $id)
            ->with(['replies'])
            ->paginate(15);

        return new CommentCollection($comment);
    }

    public function update(UpdateCommentRequest $request, $id)
    {
        $request->validate([
            'body'=>'required',
        ]);

        $attr = $request->validated();

        $comment = Comment::findOrFail($id);
        $comment->body = $attr['body'];
        $comment->parent_id = isset($attr['parent_id']) ? $attr['parent_id'] : null;
        $comment->user_id = $request->user()->id;
        $comment->task_id = $attr['task_id'];
        $comment->save();

        return new CommentResource($comment);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if($comment->delete()){

            return response()->json([
                'message' => 'The comment was successfully deleted',
            ], 200);
        }

        return response()->json([
            'message' => 'A deletion error occurred',
        ], 200);
    }
}
