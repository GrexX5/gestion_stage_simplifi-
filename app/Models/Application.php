<?php

namespace App\Models;

use App\Services\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'student_id',
        'internship_id',
        'status',
        'rejection_reason',
        'submitted_at',
        'reviewed_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => \App\Events\ApplicationCreated::class,
        'updated' => \App\Events\ApplicationUpdated::class,
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

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Enregistrer une activité lors de la création d'une candidature
        static::created(function ($application) {
            ActivityLogger::logApplicationReceived($application);
        });

        // Enregistrer une activité lors de la mise à jour d'une candidature
        static::updated(function ($application) {
            $changes = $application->getChanges();
            
            // Ne pas enregistrer d'activité pour les mises à jour de timestamps uniquement
            if (count(array_diff(array_keys($changes), ['updated_at', 'created_at', 'reviewed_at'])) > 0) {
                $description = 'Statut de candidature mis à jour : ';
                
                if (isset($changes['status'])) {
                    $statusMap = [
                        'pending' => 'En attente',
                        'accepted' => 'Acceptée',
                        'rejected' => 'Refusée',
                    ];
                    
                    $oldStatus = $statusMap[$application->getOriginal('status')] ?? $application->getOriginal('status');
                    $newStatus = $statusMap[$changes['status']] ?? $changes['status'];
                    
                    $description .= "de {$oldStatus} à {$newStatus}";
                } else {
                    $description .= 'Modifications apportées';
                }
                
                ActivityLogger::log(
                    $description,
                    $application,
                    'application',
                    'updated',
                    ['changes' => $changes]
                );
            }
        });

        // Enregistrer une activité lors de la suppression d'une candidature
        static::deleted(function ($application) {
            ActivityLogger::log(
                'Candidature supprimée pour l\'offre : ' . ($application->internship->title ?? ''),
                $application,
                'application',
                'deleted',
                [
                    'internship_title' => $application->internship->title ?? null,
                    'student_name' => $application->student->user->name ?? null
                ]
            );
        });
    }
    
    /**
     * Get the user that owns the application.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
}
