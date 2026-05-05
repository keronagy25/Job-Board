<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCategory extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'job_categories';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name',
    ];
    protected $dates = ['deleted_at'];
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'deleted_at' => 'datetime',
        ];
    }
    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'categoryId', 'id'); // Assuming 'id' is the primary key in the job_categories table
    }
}
