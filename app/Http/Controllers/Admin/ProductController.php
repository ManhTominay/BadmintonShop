<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanPham; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = SanPham::orderBy('id', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
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
            'anh_dai_dien' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('anh_dai_dien');

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
        $product = SanPham::findOrFail($id);

        $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'gia_co_ban' => 'required|numeric|min:0',
            'anh_dai_dien' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('anh_dai_dien');

        if ($request->hasFile('anh_dai_dien')) {
            // Xóa ảnh cũ nếu có
            if ($product->anh_dai_dien) {
                Storage::disk('public')->delete($product->anh_dai_dien);
            }
            $data['anh_dai_dien'] = $request->file('anh_dai_dien')->store('products', 'public');
        }

        $product->update($data);

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