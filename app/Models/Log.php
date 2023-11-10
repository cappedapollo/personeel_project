<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    
    protected $table = 'logs';
    protected $guarded = [];
    
    public function action_byu() {
        return $this->belongsTo(User::class, 'action_by');
    }
    public function user() {
        return $this->belongsTo(User::class, 'module_id');
    }
    public function archive() {
        return $this->belongsTo(Archive::class, 'module_id');
    }
    public function form_data() {
        return $this->belongsTo(FormData::class, 'module_id');
    }
    
    public function getCreatedAtAttribute($value) {
        if($value) {
            $lang = app()->getLocale();
            $date = ($lang=='en') ? date('M d, Y H:i', strtotime($value)) : date('d M Y H:i', strtotime($value));
            return $date;
        }
    }
    
}
