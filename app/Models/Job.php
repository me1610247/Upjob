<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
 
protected $fillable = [
    'title',
    'location',
    'salary',
    'category_id',
    'job_type_id',
    'user_id',
    'vacancy',
    'latitude',
    'longitude',
    'description',
    'company_name',
    'company_location',
    'image',
    'residential_type',
    'bathrooms',
    'keywords',
    'experience',
    'created_at',
    'updated_at',
];

    use HasFactory;
    public function jobType(){
        return $this->belongsTo(JobType::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function applications(){
        return $this->hasMany(JobApplication::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function employer(){
        return $this->belongsTo(User::class,'user_id');
    }
}
