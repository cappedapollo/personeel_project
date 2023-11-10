<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    
    protected $table = 'questions';
    protected $guarded = [];
    
    public function sub_category() {
        return $this->belongsTo(SubCategory::class);
    }
}
