<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Events\UserSaved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'email',
        'prefixname',
        'middlename',
        'lastname',
        'suffixname',
        'username',
        'password',
        'photo',
        'type'
    ];

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
        'password' => 'hashed',
    ];

    public function save(array $options = [])
    {
        $saved = parent::save($options);

        // Trigger the UserSaved event
        event(new UserSaved($this));

        return $saved;
    }

    public function getAvatarAttribute(){
        return $this->photo ?? "avatar.png";
    }

    public function getFullnameAttribute(){
        return $this->firstname.' '.$this->middleinitial.$this->lastname;
    }

    public function getMiddleinitialAttribute(){
        return $this->middlename ? $this->middlename[0].'. ' : null;
    }

    public function getGenderAttribute()
    {
        if (strpos(strtolower($this->prefixname), 'mr') !== false) {
            return 'Male';
        } elseif (strpos(strtolower($this->prefixname), 'mrs') !== false || strpos(strtolower($this->prefixname), 'miss') !== false) {
            return 'Female';
        }
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }
}
