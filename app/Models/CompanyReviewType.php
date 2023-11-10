<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyReviewType extends Model
{
    use HasFactory;
    
    protected $table = 'company_review_types';
    protected $guarded = [];
    
    public function company() {
        return $this->belongsTo(Company::class);
    }
    public function review_type() {
        return $this->belongsTo(ReviewType::class);
    }
}
