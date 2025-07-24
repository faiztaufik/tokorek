<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class TechnicianBrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('technician.pages.brand.index', [
            'title' => 'Merk Perangkat',
            'brands' => $brands,
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255|unique:brands,name',
            ]);

            // Simpan ke database
            Brand::create([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Brand berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan brand: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
        ]);

        try {
            $brand->update([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Data merek berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui merek: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function delete(Brand $brand)
    {
        try {
            $brand->delete();
            return redirect()->back()->with('success', 'Merk berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus merk: ' . $e->getMessage());
        }
    }
}
