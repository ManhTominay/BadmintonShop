<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Chức năng khóa hoặc mở khóa tài khoản
    public function toggleLock($id)
    {
        $user = User::findOrFail($id);
        
        // Không cho phép tự khóa chính tài khoản admin đang đăng nhập
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể khóa chính tài khoản của mình!');
        }

        // Đảo trạng thái (Ví dụ: nếu đang hoạt động (1) thì chuyển thành khóa (0) và ngược lại)
        $user->trang_thai = $user->trang_thai == 1 ? 0 : 1;
        $user->save();

        $statusMessage = $user->trang_thai == 1 ? 'Đã mở khóa tài khoản.' : 'Đã khóa tài khoản thành công.';
        return back()->with('success', $statusMessage);
    }
}