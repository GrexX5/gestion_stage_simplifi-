<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'properties' => 'collection',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'type',
        'event',
        'batch_uuid'
    ];

    /**
     * Get the subject of the activity.
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user that triggered the activity.
     */
    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the extra properties with the given name.
     *
     * @param string $propertyName
     * @param mixed $default
     * @return mixed
     */
    public function getExtraProperty(string $propertyName, $default = null)
    {
        return $this->properties->get($propertyName, $default);
    }

    /**
     * Scope a query to only include activities by a given causer.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $causer
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCausedBy($query, Model $causer)
    {
        return $query->where('causer_type', $causer->getMorphClass())
                    ->where('causer_id', $causer->getKey());
    }

    /**
     * Scope a query to only include activities for a given subject.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $subject
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForSubject($query, Model $subject)
    {
        return $query->where('subject_type', $subject->getMorphClass())
                    ->where('subject_id', $subject->getKey());
    }
}
