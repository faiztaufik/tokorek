<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Good;
use App\Models\GoodIn;
use App\Models\GoodOut;
use App\Models\Repair;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{


    public function index()
    {
        $now = Carbon::now();

        return view('admin.pages.home.index', [
            'title' => 'Dashboard',

            // User Metrics
            'totalUsers' => User::count(),
            'totalCustomers' => User::where('role', 'customer')->count(),
            'totalTechnicians' => User::where('role', 'technician')->count(),

            // Repair Metrics
            'totalRepairs' => Repair::count(),
            'totalIncome' => Repair::sum('total_price'),

            // Time-Based Income
            'dailyIncome' => Repair::whereDate('created_at', $now->toDateString())->sum('total_price'),
            'weeklyIncome' => Repair::whereBetween('created_at', [
                $now->copy()->startOfWeek()->startOfDay(),
                $now->copy()->endOfWeek()->endOfDay(),
            ])->sum('total_price'),
            'monthlyIncome' => Repair::whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->sum('total_price'),

            // Other Data
            'totalServices' => Service::count(),
            'totalGoods' => Good::count(),
            'totalGoodIns' => GoodIn::sum('quantity'),
            'totalGoodOuts' => GoodOut::sum('quantity'),
            'totalCategories' => Category::count(),
            'totalBrands' => Brand::count(),
        ]);
    }
}
