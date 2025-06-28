<?php 
namespace App\Imports;

use App\Models\Job;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobsImport implements ToModel,WithHeadingRow
{
    public function model(array $row)
    {
        $userIds = User::pluck('id')->toArray(); // Get all existing user IDs


        return new Job([
            'title' => $row['title'],     
            'location' => $row['location'],      
            'salary' => $row['price'],
            'category_id' => rand(1, 4),
            'job_type_id' => rand(1, 5),
            'user_id' => $userIds ? $userIds[array_rand($userIds)] : 1, // Use a random existing user, fallback to 1
            'vacancy' => rand(1, 15),
            'latitude' => $this->randomFloat(22.0, 31.7),
            'longitude' => $this->randomFloat(25.0, 35.0),
            'description' => 'Imported from Excel',
            'company_name' => $row['city'],
            'image' => 'job_images/property' . rand(1, 20) . '.jpg',
            'residential_type' => 'Apartment',
            'bathrooms' => $row['bathroom'],
            'keywords' => $row['type'],
            'experience' =>rand(1, 5),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function randomFloat($min, $max, $decimals = 6)
    {
        $scale = pow(10, $decimals);
        return mt_rand($min * $scale, $max * $scale) / $scale;
    }
}
