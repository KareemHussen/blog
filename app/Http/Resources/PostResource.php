<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'image' => $this->when($this->getFirstMediaUrl() != "", $this->getFirstMediaUrl()),
            'comments' =>  $this->whenLoaded('comments', function () {
                return CommentResource::collection($this->comments)->response()->getData();
            }),
            
        ];
    }
}
