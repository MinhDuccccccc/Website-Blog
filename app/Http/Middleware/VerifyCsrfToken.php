<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
   protected $except = [
    'admin/login',
    'admin/post/store',
    'contact',
    'contact/store',
    'admin/user/update/*', // ➜ Thêm vào để test PUT update user
     'post/comment/*',
     'admin/user/store',
     'search',
    // thêm route khác nếu cần test POST
];
}
