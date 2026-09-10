<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanPham; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categoryIds = [
            'vot' => 1,
            'giay' => 2,
            'cau' => 3,
            'quan-ao' => 4,
            'phu-kien' => 5,
        ];

        $category = $request->input('category', 'all');
        $search = trim((string) $request->input('search', ''));

        $query = SanPham::query();

        if (isset($categoryIds[$category])) {
            $query->where('danh_muc_id', $categoryIds[$category]);
        }

        if ($search !== '') {
            $query->where('ten_san_pham', 'like', '%' . $search . '%');
        }

        $products = $query->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'category', 'search'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'ten_san_pham' => 'required|string|max:255',
        'gia_co_ban' => 'required|numeric|min:0',
        'so_luong' => 'required|integer|min:0',
        'anh_dai_dien' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $data = $request->except('anh_dai_dien');
    
    // Tự động tạo slug từ tên sản phẩm
    $data['slug'] = \Illuminate\Support\Str::slug($request->ten_san_pham);

    if ($request->hasFile('anh_dai_dien')) {
        $data['anh_dai_dien'] = $request->file('anh_dai_dien')->store('products', 'public');
    }

    SanPham::create($data);

    return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
}

    public function edit($id)
    {
        $product = SanPham::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
{
    // 1. Tìm sản phẩm trong CSDL theo ID
    $product = SanPham::findOrFail($id);

    // 2. Lấy toàn bộ dữ liệu từ form gửi lên
    $data = $request->all();

    // 3. Xử lý ảnh đại diện nếu có tải ảnh mới lên
    if ($request->hasFile('anh_dai_dien')) {
        $data['anh_dai_dien'] = $request->file('anh_dai_dien')->store('products', 'public');
    }

    // 4. Cập nhật dữ liệu vào CSDL
    $product->update($data);

    // 5. Chuyển hướng về trang danh sách kèm thông báo thành công
    return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
}

    public function destroy($id)
    {
        $product = SanPham::findOrFail($id);
        if ($product->anh_dai_dien) {
            Storage::disk('public')->delete($product->anh_dai_dien);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Đã xoá sản phẩm!');
    }
}