<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'instructor_id',
        'title',
        'tag',
        'langs',
        'modules_count',
        'students_count',
        'culture_items',
        'avg_completion',
        'status',
    ];

    protected $casts = [
        'langs' => 'array',
        'culture_items' => 'array',
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function contents()
    {
        return $this->hasMany(CourseContent::class);
    }
}
