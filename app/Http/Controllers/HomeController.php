<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 

class HomeController extends Controller
{
    public function index(){
        $CATEGORIES = Category::where('status',1)->get();
        $JOBTYPES = JobType::where('status',1)->get();
        $JOBS = Job::where('status',1);
        if(!empty($request->keyword)){
            $jobs = $jobs->where(function($query) use ($request){
                $query->orWhere('title','like','%'.$request->keyword.'%');
                $query->orWhere('keywords','like','%'.$request->keyword.'%');
            });
        }
            // search using location
         if(!empty($request->location)){
            $JOBS = $JOBS->where('location',$request->location);
         }
            // search using category
         if(!empty($request->category)){
            $JOBS = $JOBS->where('category_id',$request->category);
         }
         if(!empty($request->experience)){
            $JOBS = $JOBS->where('experience',$request->experience);
         }
        $JOBS =$JOBS->with(['jobType','category'])->orderBy('created_at','DESC')->paginate(9);
        // Fetch categories where status is active (1) and take the top 8
        $categories = Category::where('status',1)
            ->orderBy('name','ASC')
            ->take(8)
            ->get();
        
        // Fetch featured jobs where status is active and take the top 6
        $featuredJobs = Job::where('status',1)
            ->where('isFeatured', 1)  // Only featured jobs
            ->orderBy('created_at','DESC')
            ->with('jobType')          // Eager load jobType relationship
            ->take(6)
            ->get();

        // Fetch latest jobs where status is active and take the top 6
        $latestJobs = Job::where('status',1)
            ->orderBy('created_at','DESC')
            ->with('jobType')
            ->take(6)
            ->get();

        // Pass data to the view
        return view('front.home',[
            'categories' => $categories,
            'featuredJobs' => $featuredJobs,
            'latestJobs' => $latestJobs,
            'JOBS' => $JOBS,
        ]);
    }
   
    
}
