<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CeleryToken extends Model
{
    protected $table = 'celery_tokens';
    protected $guarded = [];
    use HasFactory;
}
