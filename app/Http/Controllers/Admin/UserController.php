<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $query = User::query();

        if ($search !== '') {
            $query->where(function ($userQuery) use ($search) {
                $userQuery->where('ho_ten', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('so_dien_thoai', 'like', '%' . $search . '%');

                if (ctype_digit($search)) {
                    $userQuery->orWhere('id', (int) $search);
                }
            });
        }

        $users = $query->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
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
    public function create()
{
    return view('admin.users.create');
}

public function store(Request $request)
{
    $request->validate([
        'ho_ten' => 'required|string|max:255',
        'email' => 'required|email|unique:nguoi_dung,email',
        'mat_khau' => 'required|min:6',
        'vai_tro' => 'required|in:admin,khach_hang',
    ]);

    \App\Models\User::create([
        'ho_ten' => $request->ho_ten,
        'email' => $request->email,
        'mat_khau_hash' => bcrypt($request->mat_khau),
        'vai_tro' => $request->vai_tro,
        'trang_thai' => 1, // Mặc định kích hoạt tài khoản
    ]);

    return redirect()->route('admin.users.index')->with('success', 'Thêm tài khoản thành công!');
}
public function edit($id)
{
    $user = \App\Models\User::findOrFail($id);
    return view('admin.users.edit', compact('user'));
}

public function update(Request $request, $id)
{
    $user = \App\Models\User::findOrFail($id);

    $request->validate([
        'ho_ten' => 'required|string|max:255',
        'email' => 'required|email|unique:nguoi_dung,email,' . $id,
        'vai_tro' => 'required|in:admin,khach_hang',
        'mat_khau' => 'nullable|min:6',
    ]);

    $data = [
        'ho_ten' => $request->ho_ten,
        'email' => $request->email,
        'vai_tro' => $request->vai_tro,
    ];

    if ($request->filled('mat_khau')) {
        $data['mat_khau_hash'] = bcrypt($request->mat_khau);
    }

    $user->update($data);

    return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
}
public function destroy($id)
{
    $user = \App\Models\User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'Xóa tài khoản thành công!');
}
}