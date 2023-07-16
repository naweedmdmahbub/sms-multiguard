<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'year'];
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
    
}
