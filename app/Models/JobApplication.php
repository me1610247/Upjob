<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    public function job(){
        return $this->belongsTo(Job::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function employer(){
        return $this->belongsTo(User::class,'employer_id');
    }
    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id'); // Adjust if user_id is named differently
    }
}
