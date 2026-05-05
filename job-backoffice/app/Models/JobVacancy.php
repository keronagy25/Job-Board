<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobVacancy extends Model
{
    use HasFactory, SoftDeletes, HasUuids;
    protected $table = 'job_vacancies';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'title',
        'description',
        'location',
        'type',
        'salary',
        'required_skills',
        'veiw_count',
        'companyId', // Foreign key to the companies table
        'categoryId', // Foreign key to the job_categories table
    ];
    protected $dates = ['deleted_at'];
    protected function casts(): array
    {        return [
            'id' => 'string',
            'deleted_at' => 'datetime',
        ];
    }
    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'categoryId', 'id'); // Assuming 'id' is the primary key in the job_categories table
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'companyId', 'id'); // Assuming 'id' is the primary key in the companies table
    }
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'jobId', 'id'); // Assuming 'id' is the primary key in the job_vacancies table
    }
}
