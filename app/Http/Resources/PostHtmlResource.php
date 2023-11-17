<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostHtmlResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->image,
            'author' => $this->writer->author,
            'news_content' => $this->news_content,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'writer' => $this->whenLoaded('writer'),
            // Tambahkan properti lain yang ingin Anda tampilkan di tampilan HTML
        ];
    }
}
