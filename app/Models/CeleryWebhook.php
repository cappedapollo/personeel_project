<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CeleryWebhook extends Model
{
    protected $table = 'celery_webhooks';
    protected $guarded = [];
    use HasFactory;
}
