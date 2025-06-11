<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class Convention extends Model
{
    protected $fillable = [
        'application_id',
        'status',
        'document',
        'teacher_validated',
        'company_validated'
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
