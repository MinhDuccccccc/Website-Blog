<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ContactLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'contact_logs';

    protected $fillable = [
        'contact_id',
        'name',
        'address',
        'phone',
        'subject',
        'message',
        'created_at',
        'raw_data',
    ];
}
