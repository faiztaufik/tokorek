<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Good;
use App\Models\GoodIn;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminGoodInController extends Controller
{
    public function index(Request $request)
    {
        $goods = Good::all();
        $query = GoodIn::with('good')->latest();

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date_in', [$request->start_date, $request->end_date]);
        }

        $goodsIn = $query->get();

        return view('admin.pages.good-in.index', [
            'title' => 'Barang Masuk',
            'goodsIn' => $goodsIn,
            'goods' => $goods,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'good_id' => 'required|exists:goods,id',
                'quantity' => 'required|integer|min:1',
                'date_in' => 'required|date',
                'note' => 'nullable|string|max:255',
            ]);

            GoodIn::create($validated);

            // Tambah stok barang
            $good = Good::find($validated['good_id']);
            $good->increment('stock', $validated['quantity']);

            return redirect()->back()->with('success', 'Barang masuk berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan barang masuk: ' . $e->getMessage());
        }
    }

    public function destroy(GoodIn $goodin)
    {
        try {
            // Kurangi stok barang
            $good = $goodin->good;
            $good->decrement('stock', $goodin->quantity);

            $goodin->delete();
            return redirect()->back()->with('success', 'Barang masuk berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus barang masuk: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        $query = GoodIn::with('good')->latest();

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date_in', [$request->start_date, $request->end_date]);
        }

        $goodsIn = $query->get();

        $pdf = Pdf::loadView('admin.pages.good-in.pdf', [
            'goodsIn' => $goodsIn,
            'title' => 'Laporan Barang Masuk',
        ]);

        return $pdf->download('laporan-barang-masuk.pdf');
    }
}
