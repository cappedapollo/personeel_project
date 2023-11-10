<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    
    protected $table = 'forms';
    protected $guarded = [];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function created_by() {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function form_data() {
        return $this->hasMany(FormData::class);
    }
}
