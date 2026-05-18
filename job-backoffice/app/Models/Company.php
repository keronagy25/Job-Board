<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes, HasUuids;
    protected $table = 'companies';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'address',
        'industry',
        'website',
        'ownerId', // Foreign key to the users table
    ];
    protected $dates = ['deleted_at'];
    protected function casts(): array
    {        return [
            'id' => 'string',
            'deleted_at' => 'datetime',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerId', 'id'); // Assuming 'id' is the primary key in the users table
    }
    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'companyId', 'id'); // Assuming 'id' is the primary key in the companies table
    }
    public function jobApplications()
    {
        return $this->hasManyThrough(JobApplication::class, JobVacancy::class, 'companyId', 'jobId', 'id', 'id'); // Assuming 'id' is the primary key in the companies table and 'jobId' is the foreign key in the job_applications table
    }
}
