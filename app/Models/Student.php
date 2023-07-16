<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;
    protected $guard = 'student';
    protected $fillable = ['name', 'email', 'number', 'department_id', 'guardian_number', 'password'];
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function semesters()
    {
        return $this->belongsToMany(Semester::class);
    }
    
}
