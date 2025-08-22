<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as MongoModel;

class LoginLog extends MongoModel

{
    protected $connection = 'mongodb'; // Sử dụng MongoDB

    protected $collection = 'login_logs'; // Tên collection MongoDB (giống tên bảng)

    protected $fillable = [
        'user_id',
        'email',
        'raw_data',
    ];
}
