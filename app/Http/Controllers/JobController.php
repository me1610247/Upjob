<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use App\Models\SavedJobs;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Notifications\JobApplicationNotification;

class JobController extends Controller
{
    public function showNearbyProperties(Request $request)
    {
        $area = $request->area;
        $lat = $request->lat;
        $lon = $request->lon;
    
        // تحديد مجموعة المنطقة
        $areaGroup = $this->determineAreaGroup($area);
    
        // البحث في جدول العقارات
        $properties = Job::where(function ($query) use ($areaGroup) {
            foreach ($areaGroup as $a) {
                $query->orWhere('location', 'like', "%$a%");
            }
        })->with(['category', 'jobType'])->paginate(9);
    
        return view('properties.nearby', [
            'properties' => $properties,
            'userArea' => $area,
            'userLat' => $lat,
            'userLon' => $lon,
        ]);
    }

    private function determineAreaGroup($area)
    {
        $area = strtolower($area);
    
        $groups = [
            'nasr city' => ['nasr city', 'مدينة نصر', 'nasser city'],
            'downtown' => ['وسط البلد','mokattam','downtown', 'القاهرة', 'السيدة زينب', 'باب الخلق', 'جاردن سيتي'],
            'maadi' => ['المعادي', 'maadi'],
            'mokattam' => ['mokattam', 'middle plateau', 'الهضبة الوسطى','المقطم'],
            'new cairo' => ['new cairo', 'tagamoa', 'fifth settlement', 'el tagamoa'],
            'abbasiya' => ['العباسية', 'abbasiya','Abbasiya', 'عين شمس', 'جامعة عين شمس'],
            'ain_shams' => [
                'ain shams',
                'ain shams university',
                'Abbasiya',
                'العباسية',
                'جامعة عين شمس',
                'el abbaseya',
                'zaytoun',
                'zaitoun',
                'helmeyet el zaytoun',
                'marg',
                'el marg',
                'matareya',
                'el matareya',
                'el daher',
                'daher',
                'hadayek el kobba',
                'manshiet naser',
                'manshiyat nasr'
            ],
            '6 october' => ['6 october', 'october', 'sheikh zayed'],
            'giza' => ['giza', 'dokki', 'mohandessin', 'haram'],
        ];
    
        foreach ($groups as $group => $keywords) {
            foreach ($keywords as $keyword) {
                if (stripos($area, $keyword) !== false) {
                    return $keywords;
                }
            }
        }
    
        return [$area]; // fallback في حالة ما لقيناش مجموعة
    }
    
    public function getByArea(Request $request)
    {
        $area = strtolower(trim($request->area));

        // جروبات تقريبية للمناطق
        $areaGroups = [
            'maadi' => ['maadi', 'degla', 'zahraa maadi'],
            'mokattam' => ['mokattam', 'middle plateau', 'الهضبة الوسطى'],
            'new cairo' => ['new cairo', 'tagamoa', 'fifth settlement', 'el tagamoa'],
            'nasr city' => ['nasr city', 'madinat nasr'],
            '6 october' => ['6 october', 'october', 'sheikh zayed'],
            'giza' => ['giza', 'dokki', 'mohandessin', 'haram'],
            'sayyida_zeinab' => ['sayyida zeinab', 'al-sayyida zeinab', 'وسط البلد', 'downtown', 'maadi', 'mokattam'],
            'ain_shams' => [
                'ain shams',
                'ain shams university',
                'abbassia',
                'العباسية',
                'el abbaseya',
                'zaytoun',
                'zaitoun',
                'helmeyet el zaytoun',
                'marg',
                'el marg',
                'matareya',
                'el matareya',
                'el daher',
                'daher',
                'hadayek el kobba',
                'manshiet naser',
                'manshiyat nasr'
            ],
        ];

        $matchedAreas = [];

        foreach ($areaGroups as $group => $areas) {
            foreach ($areas as $a) {
                if (str_contains($area, strtolower($a))) {
                    $matchedAreas = $areas;
                    break 2;
                }
            }
        }

        if (empty($matchedAreas)) {
            $matchedAreas = [$area]; // fallback
        }

        $properties = DB::table('jobs')
            ->where(function ($query) use ($matchedAreas) {
                foreach ($matchedAreas as $area) {
                    $query->orWhere('location', 'like', "%$area%");
                }
            })
            ->get();

        return response()->json(['properties' => $properties]);
    }

    public function createJob()
    {
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $job_types = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
        return view('front.account.job.create', [
            'categories' => $categories,
            'job_types' => $job_types
        ]);
    }
    public function saveJob(Request $request)
    {
        $rules = [
            'title' => 'required|min:5|max:100',
            'category' => 'required',
            'jobType' => 'required',
            'location' => 'required',
            'salary' => 'required',
            'description' => 'required|min:3|max:2000',
            'company_name' => 'required',
            'keywords' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Add validation for residential properties
        if ($request->category == 1) {
            $rules['residential_type'] = 'required|string';
            $rules['bathrooms'] = 'required|integer|min:1';
            $rules['vacancy'] = 'required|integer|min:1';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $job = new Job();
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->user_id = Auth::user()->id;
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

            // Store residential-specific fields only if the category is residential
            if ($request->category == 1) {
                $job->residential_type = $request->residential_type;
                $job->bathrooms = $request->bathrooms;
                $job->vacancy = $request->vacancy;
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('job_images', 'public');
                $job->image = $imagePath;
            }

            $job->save();

            return redirect()->route('account.myJobs')->with('success', 'Property Posted successfully!');
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }


    public function myJobs()
    {
        $jobs = Job::where('user_id', Auth::user()->id)->with(['category', 'jobType'])->orderBy('created_at', 'DESC')->paginate(10);
        $categories = Category::where('status', 1)
            ->orderBy('name', 'ASC')
            ->get();
        return view('front.account.job.my-jobs', [
            'jobs' => $jobs,
            'categories' => $categories,

        ]);
    }
    public function editJob(Request $request, $id)
    {
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $job_types = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $id,
        ])->first();
        if ($job == null) {
            abort(404);
        }
        return view('front.account.job.edit', [
            'categories' => $categories,
            'job_types' => $job_types,
            'job' => $job,
        ]);
    }
    public function viewJob(Request $request, $id)
    {
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $job_types = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $id,
        ])->first();
        if ($job == null) {
            abort(404);
        }
        return view('front.account.job.view', [
            'categories' => $categories,
            'job_types' => $job_types,
            'job' => $job,
        ]);
    }
    public function updateJob(Request $request, $id)
    {

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
            $job = Job::find($id);
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->user_id = Auth::user()->id;
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
            $job->save();
            session()->flash('success', 'Property Updated Successfully');
            return response()->json([
                'status' => true,
                'redirect_url' => route('account.myJobs'),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function deleteJob(Request $request)
    {
        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $request->jobId
        ])->first();

        if ($job == null) {
            session()->flash('error', 'Property is already deleted or not found');
            return response()->json([
                'status' => false,
            ]);
        }
        Job::where('id', $request->jobId)->delete();
        session()->flash('success', 'Job "' . $job->title . '" deleted Successfully');
        return response()->json([
            'status' => true,
        ]);
    }
    public function details($id)
    {
        $job = Job::where(['id' => $id, 'status' => 1])->with(['jobType', 'user', 'category'])->first();
        if ($job == null) {
            abort(404);
        }
        return view('front.details', [
            'job' => $job,
        ]);
    }
    public function applyJob(Request $request)
    {
        $id = $request->id;

        $job = Job::where('id', $id)->first();

        // If job not found in db
        if ($job == null) {
            $message = 'Job does not exist.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // You cannot apply on your own job
        $employer_id = $job->user_id;

        if ($employer_id == Auth::user()->id) {
            $message = 'You cannot apply on your own property.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // You cannot apply on a job twice
        $jobApplicationCount = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();

        if ($jobApplicationCount > 0) {
            $message = 'You already applied on this property.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // Create a new job application
        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();

        $message = 'You have successfully applied.';

        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function showAppliedJobs()
    {
        // Get the ID of the logged-in employer
        $employerId = Auth::user()->id;

        // Fetch all jobs posted by the employer
        $jobs = Job::where('user_id', $employerId)->get();

        // Fetch applications for each job where the user has applied
        $appliedJobs = [];
        foreach ($jobs as $job) {
            $applications = JobApplication::where('job_id', $job->id)
                ->with('user') // Load the user who applied
                ->get();
            if ($applications->isNotEmpty()) {
                $appliedJobs[] = [
                    'job' => $job,
                    'applications' => $applications,
                ];
            }
        }

        // Pass the applied jobs to the view
        return view('front.account.applied', compact('appliedJobs'));
    }
    public function myAppliedJobs()
    {
        $jobsApplications = JobApplication::where('user_id', Auth::user()->id)
            ->with('job', 'job.jobType', 'job.category', 'job.applications')
            ->paginate(10);
        return view('front.account.job.my-jobs-applied', [
            'jobsApplications' => $jobsApplications,
        ]);
    }
    public function favJob(Request $request)
    {
        $id = $request->id;

        $job = Job::find($id);

        if ($job == null) {
            $message = "Property does not found";
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $count = SavedJobs::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();
        if ($count > 0) {
            $message = "You already saved this property";
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
        $savedjob = new SavedJobs;
        $savedjob->job_id = $id;
        $savedjob->user_id = Auth::user()->id;
        $savedjob->save();
        $message = "Property Saved Successfully";
        session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }


    public function savedJobs()
    {
        // $jobsApplications =JobApplication::where('user_id',Auth::user()->id)
        // ->with('job','job.jobType','job.category','job.applications')
        // ->paginate(10);

        $SavedJobs = SavedJobs::where('user_id', Auth::user()->id)
            ->with('job', 'job.jobType', 'job.category', 'job.applications')
            ->paginate(10);

        return view('front.account.job.saved-jobs', [
            'SavedJobs' => $SavedJobs,
        ]);
    }
    public function unSaveJobs(Request $request)
    {
        $SavedJobs = SavedJobs::where([
            'id' => $request->id,
            'user_id' => Auth::user()->id
        ])->first();

        if ($SavedJobs == null) {
            $message = "Job not Found ";
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'errors' => $message
            ]);
        }

        // Access the job title from the related job before deleting
        $jobTitle = $SavedJobs->job->title;

        // Delete the saved job
        $SavedJobs->delete();

        session()->flash('success', 'Job ( "' . $jobTitle . '" ) Removed Successfully From Your Saved jobs');
        return response()->json([
            'status' => true,
        ]);
    }
}
