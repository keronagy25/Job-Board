<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use HasFactory, SoftDeletes, HasUuids;
    protected $table = 'resumes';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'filename',
        'fileUri',
        'contactDetails',
        'summary',
        'skills',
        'experience',
        'education',
        'userId', // Foreign key to the users table
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
    public function jobApplications()
    {        return $this->hasMany(JobApplication::class, 'resumeId', 'id'); // Assuming 'id' is the primary key in the resumes table
    }

}
