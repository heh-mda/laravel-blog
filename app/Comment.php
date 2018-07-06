<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const IS_DISALLOWED = 0;
    const IS_ALLOWED = 1;

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function disallow()
    {
        $this->status = Comment::IS_DISALLOWED;
        $this->save();
    }

    public function allow()
    {
        $this->status = Comment::IS_ALLOWED;
        $this->save();
    }

    public function toggleStatus()
    {
        if($this->status == 0) {
            return $this->allow();
        }

        return $this->disallow();
    }    

    public function remove()
    {
        $this->delete();
    }
}
