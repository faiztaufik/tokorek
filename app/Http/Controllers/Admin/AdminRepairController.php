<?php

namespace App\Http\Controllers\Admin;

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

class AdminRepairController extends Controller
{
    public function index(Request $request)
    {
        $repairs = Repair::with(['technician', 'laptop', 'services'])
            ->when($request->start_date, fn($query) => $query->whereDate('date_in', '>=', $request->start_date))
            ->when($request->end_date, fn($query) => $query->whereDate('date_in', '<=', $request->end_date))
            ->get();

        $laptops = Laptop::all();
        $technicians = User::where('role', 'technician')->get();

        return view('admin.pages.repair.index', [
            'title' => 'Data Perbaikan',
            'repairs' => $repairs,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'laptops' => $laptops,
            'technicians' => $technicians,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_phone_number' => 'required|string|max:20',
                'technician_id' => 'required|exists:users,id',
                'laptop_id' => 'required|exists:laptops,id',
                'model' => 'required|string|max:255',
                'customer_complaint' => 'required|string',
                'problem' => 'nullable|string',
                'service_state' => 'required|in:checking,in progress,done,taken back',
            ]);

            Repair::create([
                'receipt_code' => 'RCPT-' . strtoupper(Str::random(8)),
                'date_in' => now()->toDateString(),
                'customer_name' => $validated['customer_name'],
                'customer_phone_number' => $validated['customer_phone_number'],
                'customer_complaint' => $validated['customer_complaint'],
                'problem' => $validated['problem'] ?? null,
                'service_state' => $validated['service_state'],
                'technician_id' => $validated['technician_id'], // Ganti dari Auth::id()
                'laptop_id' => $validated['laptop_id'],
                'model' => $validated['model'],
                'total_price' => null,
            ]);

            return redirect()->back()->with('success', 'Perbaikan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data perbaikan: ' . $e->getMessage());
        }
    }

    public function show(Repair $repair)
    {
        $laptops = Laptop::all();
        $services = Service::all();
        $technicians = User::where('role', 'technician')->get(); // 👈 Added

        return view('admin.pages.repair.show', [
            'title' => 'Detail Perbaikan',
            'repair' => $repair,
            'laptops' => $laptops,
            'services' => $services,
            'technicians' => $technicians, // 👈 Added
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

            return redirect()->route('admin.repair')
                ->with('success', 'Perbaikan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data perbaikan: ' . $e->getMessage());
        }
    }




    public function export(Request $request)
    {
        $query = Repair::with(['technician', 'laptop']);

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date && $end_date) {
            $query->whereBetween('date_in', [$start_date, $end_date]);
        }

        $repairs = $query->get();

        $pdf = Pdf::loadView('admin.pages.repair.export', [
            'repairs' => $repairs,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ])->setPaper('A4', 'landscape');

        return $pdf->download('laporan-repair.pdf');
    }
}
