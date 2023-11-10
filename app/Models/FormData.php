<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    use HasFactory;
    
    protected $table = 'form_data';
    protected $guarded = [];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function form() {
        return $this->belongsTo(Form::class);
    }
    public function review_type() {
        return $this->belongsTo(ReviewType::class);
    }
    public function archive() {
        return $this->hasOne(Archive::class);
    }
    
    public function getUpdatedAtAttribute($value) {
        $date = str_replace('-', '/', $value);
        return date('d/m/Y', strtotime($date));
    }
    public function setDateAttribute($value) {
        $this->attributes['date'] = NULL;
        if($value) {
            $this->attributes['date'] = date('Y-m-d', strtotime($value));
        }
    }
    public function getDateAttribute($value) {
        if($value) {
            return date('d M Y', strtotime($value));
        }
    }
}
