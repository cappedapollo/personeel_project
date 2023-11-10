<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewType extends Model
{
    use HasFactory;
    
    protected $table = 'review_types';
    protected $guarded = [];
    
    public function form_data() {
        return $this->hasMany(FormData::class);
    }
    public function company_review_type() {
        return $this->hasOne(CompanyReviewType::class);
    }
}
