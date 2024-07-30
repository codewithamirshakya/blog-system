<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Comment "created" event.
     */
    public function creating(Post $post): void
    {
        $post->user_id = auth()->id();
    }
}
