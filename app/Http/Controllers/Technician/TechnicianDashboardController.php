<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Http\Request;

class TechnicianDashboardController extends Controller
{
    public function index()
    {
        $technicianId = auth()->id();

        $repairs = Repair::where('technician_id', $technicianId);

        return view('technician.pages.home.index', [
            'title' => 'Dashboard Teknisi',
            'totalRepairs' => $repairs->count(),
            'inProgress' => $repairs->where('service_state', 'in progress')->count(),
            'done' => $repairs->where('service_state', 'done')->count(),
            'takenBack' => $repairs->where('service_state', 'taken back')->count(),
            'totalIncome' => Repair::where('technician_id', $technicianId)
                ->whereIn('service_state', ['done', 'taken back'])
                ->sum('total_price'),
        ]);
    }
}
