<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'users';
    protected $guarded = [];
    protected static function booted() {
        static::deleted(function ($data) {
            $data->company_user()->delete();
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    private $child_users = [];
    
    public function user_role() {
        return $this->belongsTo(UserRole::class);
    }
    public function createdby() {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function company_user() {
        return $this->hasOne(CompanyUser::class);
    }
    public function manager() {
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function form() {
        return $this->hasMany(Form::class);
    }
    public function form_data() {
        return $this->hasMany(FormData::class);
    }
    public function goal_reviews() {
        return $this->hasMany(GoalReview::class, 'user_id');
    }
    public function employees() {
        return $this->hasMany(User::class, 'manager_id');
    }
    public function users() {
        return $this->hasMany(User::class, 'created_by');
    }
    
    public function getFullNameAttribute() {
        return "{$this->first_name} {$this->last_name}";
    }
    
    public function setGoogle2faSecretAttribute($value)
    {
        $this->attributes['google2fa_secret'] = encrypt($value);
    }
    public function getGoogle2faSecretAttribute($value)
    {
        return decrypt($value);
    }
    
    public function get_user_tree($user) 
    {
        $this->find_children($user);
        return $this->child_users;
    }
    
    public function find_children($user){
        $this->child_users[] = $user->id;
    
        if($user->employees->count() > 0){
            foreach($user->employees as $child){
                $this->find_children($child);
            }
        }
    }
}
