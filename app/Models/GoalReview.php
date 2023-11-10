<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalReview extends Model
{
    use HasFactory;
    
    protected $table = 'goal_reviews';
    protected $guarded = [];
    
    public function added_by() {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
