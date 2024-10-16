<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
class JobHomeController extends Controller
{
    public function index(Request $request){
        $categories = Category::where('status',1)->get();
        $jobTypes = JobType::where('status',1)->get();
        $jobs = Job::where('status',1);
        // search using keyword
        if(!empty($request->keyword)){
            $jobs = $jobs->where(function($query) use ($request){
                $query->orWhere('title','like','%'.$request->keyword.'%');
                $query->orWhere('keywords','like','%'.$request->keyword.'%');
            });
        }
            // search using location
         if(!empty($request->location)){
            $jobs = $jobs->where('location',$request->location);
         }
            // search using category
         if(!empty($request->category)){
            $jobs = $jobs->where('category_id',$request->category);
         }
         if(!empty($request->experience)){
            $jobs = $jobs->where('experience',$request->experience);
         }
        $jobs =$jobs->with(['jobType','category']);
        if($request->sort == '0'){
             $jobs=$jobs->orderBy('created_at','ASC');
        }else{
             $jobs=$jobs->orderBy('created_at','DESC');
         }
        $jobs=$jobs->paginate(9);
        return view('front.jobs',[
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
        ]);
    }
}
