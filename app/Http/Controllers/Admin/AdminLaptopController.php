<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Laptop;
use Illuminate\Http\Request;

class AdminLaptopController extends Controller
{
    public function index()
    {
        $laptops = Laptop::with('brand')->get();
        $brands = Brand::all();
        return view('admin.pages.laptop.index', [
            'title' => 'Seri Laptop',
            'laptops' => $laptops,
            'brands' => $brands,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:laptops,name',
                'brand_id' => 'required|exists:brands,id',
            ]);

            Laptop::create([
                'name' => $request->name,
                'brand_id' => $request->brand_id,
            ]);

            return redirect()->back()->with('success', 'Laptop berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan laptop: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Laptop $laptop)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:laptops,name,' . $laptop->id,
                'brand_id' => 'required|exists:brands,id',
            ]);

            $laptop->update([
                'name' => $request->name,
                'brand_id' => $request->brand_id,
            ]);

            return redirect()->back()->with('success', 'Laptop berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui laptop: ' . $e->getMessage());
        }
    }

    public function delete(Laptop $laptop)
    {
        try {
            $laptop->delete();
            return redirect()->back()->with('success', 'Laptop berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus laptop: ' . $e->getMessage());
        }
    }
}
