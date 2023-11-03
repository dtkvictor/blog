<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'email_verified_at',
        'two_factor_confirmed_at',
        'current_team_id',
        'profile_photo_url'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];    

    public function setNameAttribute($value)
    {        
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function setPasswordAttribute($value)
    {        
        $this->attributes['password'] = bcrypt($value);
    }

    public function setPictureAttribute($value)
    {
        $picture = $this->attributes['picture'] ?? null;

        if(!empty($picture) && Storage::exists($picture)) {
            Storage::delete($picture);
        }

        $this->attributes['picture'] = $value;
    }

    public function getPictureAttribute()
    {
        if(empty($this->attributes['picture'])) { 
            return asset('assets/image/profile.jpg');
        }
        return 'storage/'.$this->attributes['picture'];
    }

    public function post() 
    {
        return $this->hasMany(Post::class, 'user', 'id');
    }
    
    public function liked()
    {        
        return $this->belongsToMany(Post::class, 'likes', 'user', 'id');
    }

}
