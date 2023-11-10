<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;
    
    protected $table = 'archives';
    protected $guarded = [];
    protected static function booted() {
        static::deleted(function ($data) {
            # delete file from bucket
            if($data->file) {
                $file_key = $data->file->file_key;
                if($file_key) {
                    deleteFromBucket($file_key);
                }
            }
            $data->file()->delete();
            $data->form_data()->delete();
        });
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function form_data() {
        return $this->belongsTo(FormData::class);
    }
    public function created_by() {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function file() {
        return $this->belongsTo(File::class);
    }
    
    public function getCreatedAtAttribute($value) {
        $date = str_replace('-', '/', $value);
        return date('d M Y', strtotime($date));
    }
    public function getReviewedOnAttribute($value) {
        $date = str_replace('-', '/', $value);
        return date('d M Y', strtotime($date));
    }
}
