<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    
    protected $table = 'files';
    protected $guarded = [];
    /* protected static function booted() {
        static::deleted(function ($data) {
            
        });
    } */
}
