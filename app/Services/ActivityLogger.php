<?php

namespace App\Services;

use App\Models\Internship;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Log when an internship is created
     *
     * @param Internship $internship
     * @return void
     */
    public static function logInternshipCreated(Internship $internship)
    {
        activity()
            ->causedBy(Auth::user())
            ->performedOn($internship)
            ->log('Nouvelle offre de stage créée : ' . $internship->title);
    }

    /**
     * General log method
     *
     * @param string $description
     * @param mixed $subject
     * @param array $properties
     * @return void
     */
    public static function log(string $description, $subject = null, array $properties = [])
    {
        $activity = activity()
            ->causedBy(Auth::user())
            ->withProperties($properties);

        if ($subject) {
            $activity->performedOn($subject);
        }

        $activity->log($description);
    }
}
