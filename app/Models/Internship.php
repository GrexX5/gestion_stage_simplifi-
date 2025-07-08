<?php

namespace App\Models;

use App\Services\ActivityLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Internship extends Model
{
    protected $fillable = [
        'company_id',
        'title',
        'description',
        'duration',
        'skills',
        'is_active',
        'application_deadline',
        'start_date',
        'location',
        'salary',
        'remote_allowed'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'remote_allowed' => 'boolean',
        'application_deadline' => 'date',
        'start_date' => 'date',
        'skills' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Enregistrer une activité lors de la création d'une offre de stage
        static::created(function ($internship) {
            ActivityLogger::logInternshipCreated($internship);
        });

        // Enregistrer une activité lors de la mise à jour d'une offre de stage
        static::updated(function ($internship) {
            $changes = $internship->getChanges();
            
            // Ne pas enregistrer d'activité pour les mises à jour de timestamps uniquement
            if (count(array_diff(array_keys($changes), ['updated_at', 'created_at'])) > 0) {
                ActivityLogger::log(
                    'Offre de stage mise à jour : ' . $internship->title,
                    $internship,
                    [
                        'model_type' => 'internship',
                        'action' => 'updated',
                        'changes' => $changes
                    ]
                );
            }
        });

        // Enregistrer une activité lors de la suppression d'une offre de stage
        static::deleted(function ($internship) {
            ActivityLogger::log(
                'Offre de stage supprimée : ' . $internship->title,
                $internship,
                ['type' => 'internship'],
                'deleted'
            );
        });
    }
}
