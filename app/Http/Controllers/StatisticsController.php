<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        // عدد المستخدمين، الوظائف، ... إلخ
        $platformStats = [
            'total_users' => User::count(),
            'active_jobs' => Job::where('status', 1)->count(),
            'applications' => JobApplication::count(),
            'satisfaction' => 92,
        ];
    
        // تفاوت الأسعار (مثلاً متوسط سعر لكل مدينة)
        $priceDistribution = Job::selectRaw('location, AVG(salary) as avg_salary')
                                ->groupBy('location')
                                ->orderByDesc('avg_salary')
                                ->limit(10)
                                ->get();
    
        // أكثر الأماكن انتشاراً
        $popularLocations = Job::selectRaw('location, COUNT(*) as total')
                                ->groupBy('location')
                                ->orderByDesc('total')
                                ->limit(10)
                                ->get();
    
        return view('charts', compact('platformStats', 'priceDistribution', 'popularLocations'));
    }
    
}
