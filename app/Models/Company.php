<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    
    protected $table = 'companies';
    protected $guarded = [];
    protected static function booted() {
        static::deleted(function ($data) {
            # delete file from bucket
            if($data->file) {
                $file_key = $data->file->file_key;
                if($file_key) {
                    deleteFromBucket($file_key);
                }
            }

            $data->company_user()->delete();
            $data->file()->delete();
        });
    }
    
    public function company_user() {
        return $this->hasMany(CompanyUser::class);
    }
    public function created_by() {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function file() {
        return $this->belongsTo(File::class, 'logo');
    }
    public function country() {
        return $this->belongsTo(Country::class);
    }
    public function employee_no() {
        return $this->belongsTo(EmployeeNo::class);
    }
    
    public function getCreatedAtAttribute($value) {
        $date = str_replace('-', '/', $value);
        return date('d/m/Y', strtotime($date));
    }
}
