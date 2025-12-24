<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //Auth là một Facade của Laravel, đại diện cho hệ thống xác thực người dùng.
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
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
       $post = Post::where('slug', $slug)->first();
       $post ->update([
        'view_counts' => $post ->view_counts +1
       ]);

       $relate = Post::where('category_id', $post ->category_id)->take(2)->inRandomOrder()->get();
       
       $highlight = Post::where('highlight_post', 1)
            ->take(3)->get();

        // $comments = Comment::where('post_id', $post ->id)->paginate(5);
       return view('web.post', compact('post', 'relate', 'highlight'));
    }

public function comment(Request $request, $id)
{
    // Giữ nguyên logic cũ: lưu comment vào MySQL
    $comment = Comment::create([
        'content' => $request->get('content'),
        'user_id' => Auth::id(),
        'post_id' => $id
    ]);

    // Chuẩn bị payload gửi sang Kafka
    $payload = [
        'comment_id' => $comment->id,
        'post_id'    => $comment->post_id,
        'user_id'    => $comment->user_id,
        'user_name'  => Auth::user()->name ?? 'Anonymous',
        'content'    => $comment->content,
        'created_at' => now()->toDateTimeString()
    ];

    // Gửi dữ liệu comment sang Kafka topic "comment-created"
    try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/vnd.kafka.json.v2+json',
            'Accept' => 'application/vnd.kafka.v2+json',
        ])->post('http://localhost:8082/topics/comment-created', [
            "records" => [
                ["value" => $payload]
            ]
        ]);

        Log::info('Comment sent to Kafka successfully', [
            'status' => $response->status(),
            'payload' => $payload
        ]);
    } catch (\Exception $e) {
        Log::error('Kafka error when sending comment: ' . $e->getMessage());
    }

    return redirect()->back();
}

    public function category()
    {
        $posts= Post::paginate(4); //lấy danh sách post (mỗi trang 4 bài viết)
        $categories= Category::all();
        return view('web.category', compact('posts','categories'));
    }

    public function categorySlug($slug)
    {
        $category = Category::where('slug', $slug) ->first();
        $posts= Post::where('category_id',$category->id)->paginate(1);
        $categories= Category::all();
        return view('web.category', compact('posts','categories'));
    }
    public function contact()
    {
        return view('web.contact');
    }

    public function sendContact(Request $request)
    {
        // Bước 1: Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Bước 2: Tạo contact nếu hợp lệ
          $contact = Contact::create($validated);

        // Bước 3: Chuẩn bị payload gửi sang Kafka
           $payload = [
        'contact_id' => $contact->id,
        'name'       => $contact->name,
        'address'    => $contact->address,
        'phone'      => $contact->phone,
        'subject'    => $contact->subject,
        'message'    => $contact->message,
        'created_at' => now()->toDateTimeString(),
    ];
        // Bước 4: Gửi dữ liệu sang Kafka topic "contact-created"
            try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/vnd.kafka.json.v2+json',
            'Accept' => 'application/vnd.kafka.v2+json',
        ])->post('http://localhost:8082/topics/contact-created', [
            'records' => [
                ['value' => $payload]
            ]
        ]);

        Log::info('Contact sent to Kafka successfully', [
            'status' => $response->status(),
            'payload' => $payload
        ]);
    } catch (\Exception $e) {
        Log::error('Kafka error when sending contact: ' . $e->getMessage());
    }
        return redirect()->route('web.contact')->with('success', 'Created contact successfully');
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
    )->paginate(5)->withQueryString();
    $categories = Category::all();
    return view('web.search', compact('posts', 'categories', 'keyword'));
}

}
