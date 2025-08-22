<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Comment;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| CRUD cho 5 bảng: users, posts, categories, contacts, comments
| Thêm chức năng ĐĂNG NHẬP
|
*/

// ========== LOGIN ==========
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
});

// ========== USERS ==========
Route::get('/users', fn () => response()->json(User::all()));
Route::get('/users/{id}', fn ($id) => response()->json(User::find($id)));
Route::post('/users', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required'
    ]);
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password)
    ]);
    return response()->json($user, 201);
});
Route::put('/users/{id}', function (Request $request, $id) {
    $user = User::findOrFail($id);
    $user->update($request->all());
    return response()->json($user);
});
Route::delete('/users/{id}', fn ($id) => response()->json(User::destroy($id)));

// ========== POSTS ==========
Route::get('/posts', fn () => response()->json(Post::all()));
Route::get('/posts/{id}', fn ($id) => response()->json(Post::find($id)));
Route::post('/posts', function (Request $request) {
    $request->validate([
        'title' => 'required',
        'content' => 'required',
        'user_id' => 'required|exists:users,id',
        'category_id' => 'required|exists:categories,id'
    ]);
    $post = Post::create($request->all());
    return response()->json($post, 201);
});
Route::put('/posts/{id}', function (Request $request, $id) {
    $post = Post::findOrFail($id);
    $post->update($request->all());
    return response()->json($post);
});
Route::delete('/posts/{id}', fn ($id) => response()->json(Post::destroy($id)));

// ========== CATEGORIES ==========
Route::get('/categories', fn () => response()->json(Category::all()));
Route::get('/categories/{id}', fn ($id) => response()->json(Category::find($id)));
Route::post('/categories', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'slug' => 'required|unique:categories'
    ]);
    $category = Category::create($request->all());
    return response()->json($category, 201);
});
Route::put('/categories/{id}', function (Request $request, $id) {
    $category = Category::findOrFail($id);
    $category->update($request->all());
    return response()->json($category);
});
Route::delete('/categories/{id}', fn ($id) => response()->json(Category::destroy($id)));

// ========== CONTACTS ==========
Route::get('/contacts', fn () => response()->json(Contact::all()));
Route::get('/contacts/{id}', fn ($id) => response()->json(Contact::find($id)));
Route::post('/contacts', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'subject' => 'required',
        'message' => 'required'
    ]);
    $contact = Contact::create($request->all());
    return response()->json($contact, 201);
});
Route::put('/contacts/{id}', function (Request $request, $id) {
    $contact = Contact::findOrFail($id);
    $contact->update($request->all());
    return response()->json($contact);
});
Route::delete('/contacts/{id}', fn ($id) => response()->json(Contact::destroy($id)));

// ========== COMMENTS ==========
Route::get('/comments', fn () => response()->json(Comment::all()));
Route::get('/comments/{id}', fn ($id) => response()->json(Comment::find($id)));
Route::post('/comments', function (Request $request) {
    $request->validate([
        'content' => 'required',
        'user_id' => 'required|exists:users,id',
        'post_id' => 'required|exists:posts,id'
    ]);
    $comment = Comment::create($request->all());
    return response()->json($comment, 201);
});
Route::put('/comments/{id}', function (Request $request, $id) {
    $comment = Comment::findOrFail($id);
    $comment->update($request->all());
    return response()->json($comment);
});
Route::delete('/comments/{id}', fn ($id) => response()->json(Comment::destroy($id)));

// ========== TEST ==========
Route::get('/ping', fn () => response()->json(['message' => 'API OK']));
