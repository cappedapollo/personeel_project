<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $table = 'categories';
    protected $guarded = [];
    protected static function booted() {
        static::deleted(function ($data) {
            $data->sub_category()->delete();
        });
    }
    
    public function sub_category() {
        return $this->hasMany(SubCategory::class);
    }
}
