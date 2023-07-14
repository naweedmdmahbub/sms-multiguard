<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'email', 'number', 'total_credit', 'department_head'];

    public function students(){
        return $this->hasMany(Student::class);
    }
}
