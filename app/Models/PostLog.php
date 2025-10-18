<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PostLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'post_logs';

    protected $fillable = [
        'post_id',
        'title',
        'description',
        'slug',
        'created_at',
        'raw_data',
    ];
}
