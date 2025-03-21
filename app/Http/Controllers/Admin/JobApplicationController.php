<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;

class JobApplicationController extends Controller
{
    public function index(){
        $applications = JobApplication::orderBy('created_at','DESC')
        ->with('job','user','employer')
        ->paginate(10);
        return view('admin.job-application.show',[
            'applications' =>$applications,
        ]);
    }
    public function destroy(Request $request){
        $id = $request->id;

        $jobApplication = JobApplication::find($id);

        if($jobApplication == null){
            session()->flash('error','Job Application does not found');
            return response()->json([
            'status' => false,
          ]);
        };
        $jobApplication->delete();
        session()->flash('success','Job Application Deleted Successfully');
        return response()->json([
        'status' => true,
        'redirect_url' => route('admin.applications'),
            ]);
        return redirect()->to('admin.applications');

    }
}
