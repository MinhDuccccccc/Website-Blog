<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.login.index');
    }
   public function checkLogin(Request $request)
{
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        try {
            $payload = [
                "records" => [
                    [
                        "value" => [
                            'user_id'  => Auth::id(),
                            'email'    => Auth::user()->email,
                            'login_at' => now()->toDateTimeString() // Chuẩn Laravel + Mongo
                        ]
                    ]
                ]
            ];

            // Gửi đến Kafka REST Proxy
            $response = Http::withHeaders([
                'Content-Type' => 'application/vnd.kafka.json.v2+json',
            ])->post('http://localhost:8082/topics/user-login', $payload);

            Log::info('Kafka REST status: ' . $response->status());
            Log::info('Kafka REST response: ' . $response->body());

            if (!$response->successful()) {
                Log::error('Kafka REST error: ' . $response->status() . ' - ' . $response->body());
            }

        } catch (\Exception $e) {
            Log::error('Kafka REST Exception: ' . $e->getMessage());
        }

        return redirect()->route('admin.post.index');
    }

    return redirect()->route('admin.auth.login')->with('error', 'Invalid email or password');
}


   public function logout()
   {
        Auth::logout();
        return redirect()->route('admin.auth.login');
   }
   
   public function profile()
   {
        return view('admin.login.profile');
   }
   public function updateProfile(Request $request)
   {
    $this->validate($request, [
        'name' => 'required',
    ]);

   /** @var \App\Models\User $user */
     $user = Auth::user();


    $data = [
        'name' => $request->name,
    ];
    
    if($request->password) {
        $this->validate($request, [
            'password' => 'required|min:6|max:32',
            'confirm' => 'same:password',
        ]);
        $data['password'] = bcrypt($request->password);
    }

    $user ->update($data);
    return redirect()-> route('admin.profile.index')->with('success', 'Updated successfully');
   }
}
