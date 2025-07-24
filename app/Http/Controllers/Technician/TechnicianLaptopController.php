<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Laptop;
use Illuminate\Http\Request;

class TechnicianLaptopController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        $laptops = Laptop::with('brand')->get();
        return view('technician.pages.laptop.index', [
            'title' => 'Daftar Laptop',
            'laptops' => $laptops,
            'brands' => $brands,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:laptops,name',
                'model' => 'required|string|max:255|unique:laptops,model',
                'brand_id' => 'required|exists:brands,id',
            ]);

            Laptop::create([
                'name' => $request->name,
                'model' => $request->model,
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
                'model' => 'required|string|max:255|unique:laptops,model,' . $laptop->id,
                'brand_id' => 'required|exists:brands,id',
            ]);

            $laptop->update([
                'name' => $request->name,
                'model' => $request->model,
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
