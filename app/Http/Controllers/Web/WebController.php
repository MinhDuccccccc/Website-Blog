<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class WebController extends Controller
{
    public function home()
    {
        // Eager loading user để tránh N+1 nếu hiển thị tác giả
        $highlight = Post::with('user')
            ->where('highlight_post', 1)
            ->take(3)
            ->get();

        $new = Post::with('user')
            ->where('new_post', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('web.home', compact('highlight', 'new'));
    }

    public function post($slug)
    {
        // eager loading category + user
        $post = Post::with(['category', 'user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // tăng view
        $post->increment('view_counts');

        // Related posts (eager loading category)
        $relate = Post::with('category')
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->inRandomOrder()
            ->take(2)
            ->get();

        $highlight = Post::with('user')
            ->where('highlight_post', 1)
            ->take(3)
            ->get();

        // Eager loading comments
        $comments = Comment::with(['user', 'replies.user'])
            ->where('post_id', $post->id)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('web.post', compact(
            'post',
            'relate',
            'highlight',
            'comments'
        ));
    }

    /**
     * ===============================
     * CATEGORY – ĐIỂM TEST EAGER LOADING CHÍNH
     * ===============================
     */
    public function category()
    {
        /**
         * TRƯỚC (N+1):
         * Post::paginate(4);
         *
         * SAU (EAGER LOADING):
         * → load sẵn category + user
         */
        $posts = Post::with(['category', 'user'])
            ->paginate(4);

        $categories = Category::all();

        return view('web.category', compact('posts', 'categories'));
    }

      public function categorySlug($slug)
    {
        // page hiện tại (pagination)
        $page = request()->get('page', 1);

        // cache key duy nhất cho mỗi category + page
        $cacheKey = "category_{$slug}_posts_page_{$page}";

        $data = Cache::remember($cacheKey, 60, function () use ($slug) {
            $category = Category::where('slug', $slug)->firstOrFail();

            $posts = Post::with(['category', 'user'])
                ->where('category_id', $category->id)
                ->paginate(4);

            $categories = Category::all();

            return compact('category', 'posts', 'categories');
        });

        return view('web.category', $data);
    }

    public function comment(Request $request, $postId)
    {
        $request->validate([
            'content'   => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        if ($request->parent_id) {
            $parent = Comment::findOrFail($request->parent_id);
            $level = 0;

            while ($parent->parent) {
                $level++;
                $parent = $parent->parent;

                if ($level >= 3) {
                    return back()->withErrors(
                        'Chỉ cho phép reply tối đa 4 cấp'
                    );
                }
            }
        }

        $comment = Comment::create([
            'content'   => $request->content,
            'user_id'   => Auth::id(),
            'post_id'   => $postId,
            'parent_id' => $request->parent_id
        ]);

        // TỐI ƯU SELECT COUNT
        DB::table('posts')
            ->where('id', $postId)
            ->increment('comments_count');

        return back();
    }

    public function contact()
    {
        return view('web.contact');
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        Contact::create($validated);

        return redirect()
            ->route('web.contact')
            ->with('success', 'Created contact successfully');
    }

    public function search(Request $request)
{
    $keyword = trim($request->get('keyword'));

    if (!$keyword) {
        return redirect()->route('web.home');
    }

    $posts = Post::query()
        ->select(
            'id',
            'title',
            'slug',
            'description',
            'image',          
            'category_id',
            'user_id',
            'created_at'
        )
        ->with([
            'category:id,name,slug',
            'user:id,name'
        ])
        ->whereRaw(
            "MATCH(title, description, content) AGAINST (? IN BOOLEAN MODE)",
            [$keyword . '*']
        )
        ->orderByDesc('created_at')
        ->paginate(10)
        ->withQueryString();

    // categories ít thay đổi → không ảnh hưởng benchmark SQL search
    $categories = Category::select('id', 'name', 'slug')->get();

    return view('web.search', compact(
        'posts',
        'categories',
        'keyword'
    ));
}

}
