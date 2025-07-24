<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.pages.service.index', [
            'title' => 'Daftar Layanan',
            'services' => $services,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:services,name',
                'price' => 'required|numeric|min:0',
            ]);

            Service::create([
                'name' => $request->name,
                'price' => $request->price,
            ]);

            return redirect()->back()->with('success', 'Layanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan layanan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Service $service)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:services,name,' . $service->id,
                'price' => 'required|numeric|min:0',
            ]);

            $service->update([
                'name' => $request->name,
                'price' => $request->price,
            ]);

            return redirect()->back()->with('success', 'Layanan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui layanan: ' . $e->getMessage());
        }
    }

    public function delete(Request $request, Service $service)
    {
        try {
            $service->delete();
            return redirect()->back()->with('success', 'Layanan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus layanan: ' . $e->getMessage());
        }
    }
}
