<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImport extends Model
{
    use HasFactory;
    
    protected $table = 'user_imports';
    protected $guarded = [];
    protected static function booted() {
        static::deleted(function ($data) {
            $data->user()->delete();
        });
    }
    
    public function created_by() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function user() {
        return $this->hasMany(User::class);
    }
    
    public function getCreatedAtAttribute($value) {
        $date = str_replace('-', '/', $value);
        return date('d/m/Y', strtotime($date));
    }
}
