<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Semester extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'year'];
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
    
    // Activity Logs begins
    protected static $logAttributes = ['name', 'year'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Semester has been {$eventName}";
    }
    // Activity Logs ends
}
