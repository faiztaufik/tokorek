<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Good;
use App\Models\GoodOut;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminGoodOutController extends Controller
{
    public function index(Request $request)
    {
        $goods = Good::all();
        $query = GoodOut::with('good')->latest();

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date_out', [$request->start_date, $request->end_date]);
        }

        $goodsOut = $query->get();

        return view('admin.pages.good-out.index', [
            'title' => 'Barang Keluar',
            'goodsOut' => $goodsOut,
            'goods' => $goods,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'good_id' => 'required|exists:goods,id',
                'quantity' => 'required|integer|min:1',
                'date_out' => 'required|date',
                'note' => 'nullable|string|max:255',
            ]);

            $good = Good::findOrFail($validated['good_id']);

            if ($validated['quantity'] > $good->stock) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi.');
            }

            GoodOut::create($validated);
            $good->decrement('stock', $validated['quantity']);

            return redirect()->back()->with('success', 'Barang keluar berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan barang keluar: ' . $e->getMessage());
        }
    }

    public function destroy(GoodOut $goodout)
    {
        try {
            $goodout->good->increment('stock', $goodout->quantity);
            $goodout->delete();

            return redirect()->back()->with('success', 'Barang keluar berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus barang keluar: ' . $e->getMessage());
        }
    }



    public function exportPdf(Request $request)
    {
        $query = GoodOut::with('good')->latest();

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date_out', [$request->start_date, $request->end_date]);
        }

        $goodsOut = $query->get();

        $pdf = Pdf::loadView('admin.pages.good-out.pdf', [
            'goodsOut' => $goodsOut,
            'title' => 'Laporan Barang Keluar',
        ]);

        return $pdf->download('laporan-barang-keluar.pdf');
    }
}
