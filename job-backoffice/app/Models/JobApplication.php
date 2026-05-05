<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use HasFactory, SoftDeletes, HasUuids;
    protected $table = 'job_applications';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'status',
        'aiGeneratedScore',
        'aiGeneratedFeedback',
        'userId', // Foreign key to the users table
        'jobId', // Foreign key to the job_vacancies table
        'resumeId', // Foreign key to the resumes table
    ];
    protected $dates = ['deleted_at'];
    protected function casts(): array
    {        return [
            'id' => 'string',
            'deleted_at' => 'datetime',
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id'); // Assuming 'id' is the primary key in the users table
    }
    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'jobId', 'id'); // Assuming 'id' is the primary key in the job_vacancies table
    }
    public function resume()
    {        return $this->belongsTo(Resume::class, 'resumeId', 'id'); // Assuming 'id' is the primary key in the resumes table
    }
}
