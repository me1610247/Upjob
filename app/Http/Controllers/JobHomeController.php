<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
class JobHomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();
        $jobs = Job::where('status', 1);
    
        // Search using keyword
        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keyword . '%');
                $query->orWhere('keywords', 'like', '%' . $request->keyword . '%');
            });
        }
    
        // Search using location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }
    
        // Search using company name
        if (!empty($request->company_name)) {
            $jobs = $jobs->where('company_name', 'like', '%' . $request->company_name . '%');
        }
    
        // Search using experience
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }
        // Filter by minimum price
        if (!empty($request->min_price)) {
            $jobs = $jobs->where('salary', '>=', $request->min_price);
        }

        // Filter by maximum price
        if (!empty($request->max_price)) {
            $jobs = $jobs->where('salary', '<=', $request->max_price);
        }
        $jobs = $jobs->with(['jobType', 'category']);
    
        // Sort by creation date
        if ($request->sort == '0') {
            $jobs = $jobs->orderBy('created_at', 'ASC');
        } else {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }
    
        $jobs = $jobs->paginate(9);
    
        return view('front.jobs', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
        ]);
    }
}
