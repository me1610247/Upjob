<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, // Include the job ID if needed
            'title' => $this->title,
            'category_id' => $this->category_id, // Access the job's category_id directly
            'job_type_id' => $this->job_type_id, // Access the job's job_type_id directly
            'location' => $this->location,
            'experience' => $this->experience,
            'user_id' => $this->user_id, // Set to the job's user_id
            'vacancy' => $this->vacancy,
            'salary' => $this->salary,
            'company_name' => $this->company_name,
            'keywords' => $this->keywords,
        ];
    }
}
