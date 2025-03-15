<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Http\Resources\JobResource;
use App\Http\Requests\StoreJobRequest;
class ApiJobController extends Controller
{
    public function index(){
        return JobResource::collection(Job::all());
    }
    public function show(Job $job){
        return JobResource::make($job);
    }
  
    public function store(StoreJobRequest $request)
    {
        $job = new Job();
        $job->title = $request->title;
        $job->category_id = $request->category_id; 
        $job->job_type_id = $request->job_type_id; 
        $job->location = $request->location;
        $job->experience = $request->experience;
        $job->vacancy = $request->vacancy;
        $job->salary = $request->salary;
        $job->description = $request->description;
        $job->company_name = $request->company_name;
        $job->keywords = $request->keywords;
    
        // Assign the user_id from the authenticated user
        $job->user_id = Auth::id(); // Ensure this is not null
    
        $job->save(); // Save the job to the database
    
        return new JobResource($job); // Return the created job resource
    }
    
}
