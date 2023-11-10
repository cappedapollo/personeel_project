<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    
    protected $table = 'user_roles';
    protected $guarded = [];
    
    public function user() {
        return $this->hasMany(User::class);
    }
}
