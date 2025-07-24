<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GeneralServiceController extends Controller
{
    public function index(Request $request)
    {
        $repair = null;

        if ($request->filled('receipt_code')) {
            $repair = Repair::with(['technician', 'laptop', 'services'])
                ->where('receipt_code', $request->receipt_code)
                ->first();
        }

        return view('general.pages.service.index', [
            'title' => 'Cek Status Perbaikan',
            'repair' => $repair,
        ]);
    }

    public function export($receipt_code)
    {
        $repair = Repair::with(['technician', 'laptop', 'services'])
            ->where('receipt_code', $receipt_code)
            ->firstOrFail();

        $pdf = Pdf::loadView('general.pages.service.invoice', [
            'repair' => $repair,
        ])->setPaper('A4');

        return $pdf->download('invoice_' . $repair->receipt_code . '.pdf');
    }
}
