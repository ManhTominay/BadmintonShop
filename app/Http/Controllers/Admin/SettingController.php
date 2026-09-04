<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        // Kiểm tra phân quyền admin
        if (auth()->user()->vai_tro !== 'admin') {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang cấu hình!');
        }

        // Lấy các cấu hình hệ thống từ database
        $settings = DB::table('settings')->get();
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update system settings
     */
    public function update(Request $request)
    {
        // Kiểm tra phân quyền admin
        if (auth()->user()->vai_tro !== 'admin') {
            return redirect('/')->with('error', 'Bạn không có quyền cập nhật cấu hình!');
        }

        // Validate dữ liệu
        $validated = $request->validate([
            'shop_name' => 'nullable|string|max:255',
            'shop_email' => 'nullable|email',
            'shop_phone' => 'nullable|string|max:20',
            'shop_address' => 'nullable|string|max:500',
            'shop_description' => 'nullable|string',
        ]);

        // Cập nhật từng cấu hình
        foreach ($validated as $key => $value) {
            DB::table('settings')
                ->updateOrInsert(
                    ['key' => $key],
                    ['value' => $value, 'updated_at' => now()]
                );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Cấu hình hệ thống đã được cập nhật thành công!');
    }
}
