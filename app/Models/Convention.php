<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class Convention extends Model
{
    protected $fillable = [
        'application_id',
        'student_id',
        'company_id',
        'internship_id',
        'start_date',
        'end_date',
        'signature_date',
        'status',
        'document',
        'teacher_validated',
        'company_validated'
    ];
    
    protected $dates = [
        'start_date',
        'end_date',
        'signature_date',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'teacher_validated' => 'boolean',
        'company_validated' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        // Créer automatiquement une convention lorsqu'une nouvelle candidature est créée
        static::creating(function ($convention) {
            if (empty($convention->status)) {
                $convention->status = 'pending';
            }
            if (is_null($convention->teacher_validated)) {
                $convention->teacher_validated = false;
            }
            if (is_null($convention->company_validated)) {
                $convention->company_validated = false;
            }
        });
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function isFullyValidated()
    {
        return $this->teacher_validated && $this->company_validated;
    }
}
