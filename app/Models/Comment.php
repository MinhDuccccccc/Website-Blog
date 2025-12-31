<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'content',
        'user_id',
        'post_id',
        'parent_id',
    ];

    /**
     * Comment author
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Related post
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Parent comment (for replies)
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Child replies (recursive)
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->with(['user', 'replies'])
            ->orderBy('created_at', 'asc');
    }
}
