<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    //
}
