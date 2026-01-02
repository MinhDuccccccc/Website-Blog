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

class WebController extends Controller
{
    public function home()
    {
        $highlight = Post::where('highlight_post', 1)
            ->take(3)
            ->get();

        $new = Post::where('new_post', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('web.home', compact('highlight', 'new'));
    }

    public function post($slug)
{
    $post = Post::where('slug', $slug)->firstOrFail();

    // tăng view
    $post->increment('view_counts');

    // Related posts
    $relate = Post::where('category_id', $post->category_id)
        ->where('id', '!=', $post->id)
        ->inRandomOrder()
        ->take(2)
        ->get();

    // Highlight posts
    $highlight = Post::where('highlight_post', 1)
        ->take(3)
        ->get();

    /**
     * LOAD COMMENT CHA + REPLIES
     * Chỉ phân trang comment cha
     */
    $comments = Comment::with(['user', 'replies.user'])
        ->where('post_id', $post->id)
        ->whereNull('parent_id')
        ->orderBy('created_at', 'desc')
        ->paginate(5); // mỗi trang 5 comment cha

    return view('web.post', compact(
        'post',
        'relate',
        'highlight',
        'comments'
    ));
}


    /**
     * ===============================
     * COMMENT – reply tối đa 4 cấp
     * ===============================
     */
    public function comment(Request $request, $postId)
    {
        $request->validate([
            'content'   => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        /**
         * CHẶN REPLY > CẤP 3
         */
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

        // Lưu MySQL
        $comment = Comment::create([
            'content'   => $request->content,
            'user_id'   => Auth::id(),
            'post_id'   => $postId,
            'parent_id' => $request->parent_id
        ]);

        /**
         * TỐI ƯU SELECT COUNT
         * → tăng comments_count thay vì COUNT(*)
         * → O(1), không scan bảng comments
         */
        DB::table('posts')->increment('comments_count');

        /**
         * Kafka payload
         */
        $payload = [
            'comment_id' => $comment->id,
            'post_id'    => $comment->post_id,
            'user_id'    => $comment->user_id,
            'user_name'  => Auth::user()->name ?? 'Anonymous',
            'content'    => $comment->content,
            'parent_id'  => $comment->parent_id,
            'created_at' => now()->toDateTimeString()
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/vnd.kafka.json.v2+json',
                'Accept'       => 'application/vnd.kafka.v2+json',
            ])->post('http://localhost:8082/topics/comment-created', [
                'records' => [
                    ['value' => $payload]
                ]
            ]);

            Log::info('Comment sent to Kafka', [
                'status'  => $response->status(),
                'payload' => $payload
            ]);
        } catch (\Exception $e) {
            Log::error('Kafka comment error: ' . $e->getMessage());
        }

        return back();
    }

    public function category()
    {
        $posts = Post::paginate(4);
        $categories = Category::all();

        return view('web.category', compact('posts', 'categories'));
    }

    public function categorySlug($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::where('category_id', $category->id)
            ->paginate(4);

        $categories = Category::all();

        return view('web.category', compact('posts', 'categories'));
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

        $contact = Contact::create($validated);

        $payload = [
            'contact_id' => $contact->id,
            'name'       => $contact->name,
            'address'    => $contact->address,
            'phone'      => $contact->phone,
            'subject'    => $contact->subject,
            'message'    => $contact->message,
            'created_at' => now()->toDateTimeString(),
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/vnd.kafka.json.v2+json',
                'Accept'       => 'application/vnd.kafka.v2+json',
            ])->post('http://localhost:8082/topics/contact-created', [
                'records' => [
                    ['value' => $payload]
                ]
            ]);

            Log::info('Contact sent to Kafka', [
                'status'  => $response->status(),
                'payload' => $payload
            ]);
        } catch (\Exception $e) {
            Log::error('Kafka contact error: ' . $e->getMessage());
        }

        return redirect()
            ->route('web.contact')
            ->with('success', 'Created contact successfully');
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        if (!$keyword) {
            return redirect()->route('web.home');
        }

        $posts = Post::whereRaw(
            "MATCH(title, description, content) AGAINST (? IN BOOLEAN MODE)",
            [$keyword]
        )->paginate(10)->withQueryString();

        $categories = Category::all();

        return view('web.search', compact(
            'posts',
            'categories',
            'keyword'
        ));
    }
}
