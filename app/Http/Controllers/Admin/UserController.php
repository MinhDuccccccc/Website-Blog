<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Danh sách user
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.user.list', compact('users'));
    }

    /**
     * Form tạo user
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Lưu user mới
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:32',
            'confirm'  => 'required|same:password',
            'is_admin' => 'required|in:0,1',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => $request->is_admin,
        ]);

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Created successfully');
    }

    /**
     * Form sửa user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            abort(403, 'You are not allowed to edit admin accounts');
        }

        return view('admin.user.edit', compact('user'));
    }

    /**
     * Cập nhật user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            abort(403, 'You are not allowed to update admin accounts');
        }

        $this->validate($request, [
            'name'     => 'required|string|max:255',
            'is_admin' => 'required|in:0,1',
        ]);

        $data = [
            'name'     => $request->name,
            'is_admin' => $request->is_admin,
        ];

        if ($request->filled('password')) {
            $this->validate($request, [
                'password' => 'required|min:6|max:32',
                'confirm'  => 'required|same:password',
            ]);

            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Updated successfully');
    }

    /**
     * Xoá user
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            return back()->withErrors('You cannot delete admin accounts');
        }

        $user->delete();

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Deleted successfully');
    }
}
