<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Good;
use Illuminate\Http\Request;

class AdminGoodController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $goods = Good::with('category')->get();
        return view('admin.pages.good.index', [
            'title' => 'Inventaris Toko',
            'goods' => $goods,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('goods', 'public');
            }

            Good::create($validated);

            return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan barang: ' . $e->getMessage());
        }
    }


    public function update(Request $request, Good $good)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('goods', 'public');
            }

            $good->update($validated);

            return redirect()->back()->with('success', 'Barang berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui barang: ' . $e->getMessage());
        }
    }


    public function delete(Good $good)
    {
        try {
            $good->delete();

            return redirect()->back()->with('success', 'Barang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus barang: ' . $e->getMessage());
        }
    }
}
