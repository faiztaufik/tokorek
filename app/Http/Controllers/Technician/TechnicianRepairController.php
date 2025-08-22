<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Laptop;
use App\Models\Repair;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TechnicianRepairController extends Controller
{
    public function index(Request $request)
    {
        $repairs = Repair::with(['technician', 'laptop', 'services'])
            ->where('technician_id', Auth::id()) // ✅ filter by authenticated technician
            ->when($request->start_date, fn($query) => $query->whereDate('date_in', '>=', $request->start_date))
            ->when($request->end_date, fn($query) => $query->whereDate('date_in', '<=', $request->end_date))
            ->get();

        $laptops = Laptop::all();
        $technicians = User::where('role', 'technician')->get();

        return view('technician.pages.repair.index', [ // ⬅️ assume you're in the technician folder
            'title' => 'Data Perbaikan Saya',
            'repairs' => $repairs,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'laptops' => $laptops,
            'technicians' => $technicians,
        ]);
    }



    public function show(Repair $repair)
    {
        $laptops = Laptop::all();
        $services = Service::all();
        $technicians = User::where('role', 'technician')->get();

        return view('technician.pages.repair.show', [
            'title' => 'Detail Perbaikan',
            'repair' => $repair,
            'laptops' => $laptops,
            'services' => $services,
            'technicians' => $technicians,
        ]);
    }

    public function update(Request $request, Repair $repair)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone_number' => 'required|string|max:20',
            'laptop_id' => 'required|exists:laptops,id',
            'customer_complaint' => 'required|string',
            'problem' => 'nullable|string',
            'service_state' => 'required|in:checking,in progress,done,taken back',
            'date_taken_back' => 'nullable|date',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
        ]);

        try {
            DB::beginTransaction();

            // Update repair
            $repair->update([
                'customer_name' => $validated['customer_name'],
                'customer_phone_number' => $validated['customer_phone_number'],
                'laptop_id' => $validated['laptop_id'],
                'customer_complaint' => $validated['customer_complaint'],
                'problem' => $validated['problem'] ?? null,
                'service_state' => $validated['service_state'],
                'date_taken_back' => $validated['date_taken_back'] ?? null,
            ]);

            // Total price
            $selectedServices = $validated['services'] ?? [];
            $totalPrice = !empty($selectedServices)
                ? Service::whereIn('id', $selectedServices)->sum('price')
                : 0;

            $repair->update([
                'total_price' => $totalPrice,
            ]);

            $repair->services()->sync($selectedServices);

            DB::commit();

            return redirect()->route('technician.repair')
                ->with('success', 'Perbaikan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data perbaikan: ' . $e->getMessage());
        }
    }

    public function invoice(Repair $repair)
    {
        $pdf = Pdf::loadView('technician.pages.repair.export', [ // ← ganti 'invoice' jadi 'export'
            'repair' => $repair
        ])->setPaper('A4', 'portrait');
        return $pdf->download('invoice-' . $repair->receipt_code . '.pdf');
    }
}
