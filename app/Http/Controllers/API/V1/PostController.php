<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Requests\Post\ShowPostRequest;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->paginate();
        return $this->respondOk(PostResource::collection($posts)->response()->getData(), 'Posts fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user->id;

        $post = Post::create($data);

        if ($request->hasFile('image')) { 
            $post->addMediaFromRequest('image')->toMediaCollection();
        } 

        return $this->respondCreated(PostResource::make($post), 'Post created successfully');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post , ShowPostRequest $request)
    {
        $data = $request->validated();
        
        $per_page = $data['per_page'] ?? 15;

        $post->load(["comments" => fn($q) => $q->latest()->paginate($per_page)]);

        return $this->respondOk(PostResource::make($post), 'Posts fetched successfully');
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $user = $request->user;

        if(!$user->can('control', $post)) {
            return $this->respondUnAuthenticated('Unauthorized');
        }

        if ($request->hasFile('image')) { 
            $post->clearMediaCollection();
            $post->addMediaFromRequest('image')->toMediaCollection();
        } 

        $post->update($request->validated());

        return $this->respondOk(PostResource::make($post), 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post , Request $request)
    {

        $user = $request->user;

        if(!$user->can('control', $post)) {
            return $this->respondUnAuthenticated('Unauthorized');
        }

        $post->delete();

        return $this->respondNoContent();
    }
}
