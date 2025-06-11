<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'student_id',
        'internship_id',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
    public function convention()
    {
        return $this->hasOne(Convention::class);
    }

    //
}
