<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeNo extends Model
{
    use HasFactory;
    
    protected $table = 'employee_nos';
    protected $guarded = [];
}
