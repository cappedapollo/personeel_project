<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    
    protected $table = 'sub_categories';
    protected $guarded = [];
    protected static function booted() {
        static::deleted(function ($data) {
            $data->question()->delete();
        });
    }
    
    public function question() {
        return $this->hasMany(Question::class);
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
