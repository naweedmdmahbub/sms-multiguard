<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guard_name = 'api';
    protected $fillable= [
        'imageable_type', 'imageable_id', 'filename'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
