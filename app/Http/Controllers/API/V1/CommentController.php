<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = $request->user->id;

        $comment = Comment::create($data);
        return $this->respondCreated($comment, 'Comment created successfully');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Comment $comment , UpdateCommentRequest $request)
    {
        $data = $request->validated();
        $user = $request->user;
        
        if(!$user->can('control', $comment)) {
            return $this->respondUnAuthenticated('Unauthorized');
        }

        $comment->update($data);
        return $this->respondOk($comment, 'Comment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment , Request $request)
    {
        $user = $request->user;

        if(!$user->can('control', $comment)) {
            return $this->respondUnAuthenticated('Unauthorized');
        }
        
        $comment->delete();

        return $this->respondNoContent();
    }
}
