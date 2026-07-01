<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseContent extends Model
{
    protected $fillable = [
        'course_id',
        'type',
        'title',
        'body',
        'language',
        'culture_tag',
        'file_path',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
