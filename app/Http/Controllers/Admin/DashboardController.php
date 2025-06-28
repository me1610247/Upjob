<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;

class DashboardController extends Controller
{
    public function index(){
        $stats = [
            'total_users'   => User::count(),
            'active_jobs'   => Job::where('status', 1)->count(),
            'applications'  => JobApplication::count(),
            'satisfaction'  => 92 // ثابت حاليًا، أو ممكن تحسبه من تقييمات مثلاً
        ];
        return view('admin.dashboard', compact('stats'));

    }
}
