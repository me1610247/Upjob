<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use App\Models\SavedJobs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Fetch active categories and job types
        $categories = $this->getActiveCategories();
        $jobTypes = $this->getActiveJobTypes();

        // Fetch jobs with filters
        $jobs = $this->getFilteredJobs($request);

        // Fetch featured and latest jobs
        $featuredJobs = $this->getFeaturedJobs();
        $latestJobs = $this->getLatestJobs();

        // Fetch similar jobs for authenticated users
        $similarJobs = Auth::check() ? $this->getSimilarJobsByUser(Auth::user()->id) : collect();

        // Pass data to the view
        return view('front.home', [
            'categories' => $categories,
            'featuredJobs' => $featuredJobs,
            'latestJobs' => $latestJobs,
            'JOBS' => $jobs,
            'similarJobs' => $similarJobs,
        ]);
    }

    /**
     * Get active categories.
     *
     * @return Collection
     */
    protected function getActiveCategories(): Collection
    {
        return Category::where('status', 1)
            ->orderBy('name', 'ASC')
            ->take(8)
            ->get();
    }

    /**
     * Get active job types.
     *
     * @return Collection
     */
    protected function getActiveJobTypes(): Collection
    {
        return JobType::where('status', 1)->get();
    }

    /**
     * Get filtered jobs based on request parameters.
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function getFilteredJobs(Request $request)
    {
        $jobs = Job::where('status', 1);

        // Apply filters
        if ($request->filled('keyword')) {
            $jobs->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->keyword . '%')
                      ->orWhere('keywords', 'like', '%' . $request->keyword . '%')
                      ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('location')) {
            $jobs->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('category')) {
            $jobs->where('category_id', $request->category);
        }

        if ($request->filled('experience')) {
            $jobs->where('experience', $request->experience);
        }

        if ($request->filled('min_salary') && $request->filled('max_salary')) {
            $jobs->whereBetween('salary', [$request->min_salary, $request->max_salary]);
        }

        return $jobs->with(['jobType', 'category'])
            ->orderBy('created_at', 'DESC')
            ->paginate(9);
    }

    /**
     * Get featured jobs.
     *
     * @return Collection
     */
    protected function getFeaturedJobs(): Collection
    {
        return Job::where('status', 1)
            ->where('isFeatured', 1)
            ->orderBy('created_at', 'DESC')
            ->with('jobType')
            ->take(6)
            ->get();
    }

    /**
     * Get latest jobs.
     *
     * @return Collection
     */
    protected function getLatestJobs(): Collection
    {
        return Job::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->with('jobType')
            ->take(6)
            ->get();
    }

    
    protected function getSimilarJobsByUser($userId): Collection
{
    // Get saved job salaries for the authenticated user
    $savedJobs = SavedJobs::where('user_id', $userId)
        ->with('job') // Load the related Job model
        ->get()
        ->pluck('job'); // Extract jobs

    if ($savedJobs->isEmpty()) {
        return collect(); // No saved jobs, return an empty collection
    }

    $similarJobs = collect();

    foreach ($savedJobs as $savedJob) {
        if (!$savedJob) {
            continue; // Skip if no related job found
        }

        $salary = $savedJob->salary;
        $minSalary = $salary * 0.9; // 10% below
        $maxSalary = $salary * 1.1; // 10% above

        // Find jobs in the salary range (excluding already saved jobs)
        $jobsInRange = Job::whereBetween('salary', [$minSalary, $maxSalary])
            ->where('status', 1) // Only active jobs
            ->whereNotIn('id', $savedJobs->pluck('id')) // Exclude saved jobs
            ->limit(6)
            ->get();

        // Add a "scale" field to indicate the user_id
        foreach ($jobsInRange as $job) {
            $job->scale = $userId; // Add the user_id as a "scale" field
        }

        $similarJobs = $similarJobs->merge($jobsInRange);
    }

    return $similarJobs->unique('id'); // Remove duplicates
}
    
    
}