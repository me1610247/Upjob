<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Support\Facades\Validator; 

class JobController extends Controller
{
    public function index(){
        $jobs = Job::orderBy('created_at','ASC')->with('user','applications')->paginate(10);
        return view('admin.jobs.show',[
            'jobs'=>$jobs,
        ]);
    }
    public function edit($id){
        $job = Job::findOrFail($id);
        $categories = Category::orderBy('name','ASC')->get();
        $job_types = JobType::orderBy('name','ASC')->get();
        if($job == null){
            abort(404);
        }
        return view('admin.jobs.edit',[
            'job'=>$job,
            'categories'=>$categories,
            'job_types'=>$job_types
        ]);
    }
    public function update(Request $request, $id) {
        $job = Job::findOrFail($id);
        $rules = [
            'title' => 'required|min:5|max:100',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required',
            'salary' => 'required',
            'description' => 'required|min:3|max:2000',
            'company_name' => 'required',
            'keywords' => 'required|string',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->passes()) {
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->status = $request->status;
            $job->isFeatured = (!empty($request->isFeatured)?$request->isFeatured:0);
            $job->save();
    
            session()->flash('success','Job Updated Successfully');
            return response()->json([
            'status' => true,
            'redirect_url' => route('admin.jobs'),
        ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function destroy(Request $request){
        $id = $request->id;
        $job = Job::find($id);

        if($job == null){
            session()->flash('error','job not found !');
            return response()->json([
                'status'=>false,
            ]);
        }
        $job->delete();
        session()->flash('success','job deleted sucessfully ');
        return response()->json([
            'status'=>true,
            'redirect_url' => route('admin.jobs'),
        ]);
        return redirect()->to('admin.jobs');

    }
    
}
