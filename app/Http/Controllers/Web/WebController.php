<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //Auth là một Facade của Laravel, đại diện cho hệ thống xác thực người dùng.
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Post;


class WebController extends Controller
{
    public function home()
    {
        $highlight = Post::where('highlight_post', 1)
            ->take(3)->get();
        $new = Post::where('new_post', 1)->take(10)->get();
        return view('web.home', compact('highlight', 'new' ));
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
        Comment::create([
            'content'=>$request->get('content'),
            'user_id'=>Auth::id(),
            'post_id'=>$id  
        ]);
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
        Contact::create($validated);

        // Bước 3: Chuyển hướng kèm thông báo thành công
        return redirect()->route('web.contact')->with('success', 'Created contact successfully');
    }
}
