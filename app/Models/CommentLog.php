<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class CommentLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'comment_logs';

    protected $fillable = [
        'comment_id',
        'post_id',
        'user_id',
        'user_name',
        'content',
        'created_at',
        'raw_data'
    ];
}
