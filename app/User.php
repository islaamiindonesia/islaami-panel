<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname',
        'gender',
        'birthdate',
        'email',
        'fcm_token',
        'verification_number',
        'suspended_at',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'fcm_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'suspended_at' => 'datetime',
    ];

    /* RELATIONSHIP */
    public function videos()
    {
        return $this->belongsToMany('App\Video', 'later_video', 'user_id', 'video_id');
    }

    public function followChannels()
    {
        return $this->belongsToMany('App\Channel', 'followers', 'user_id', 'channel_id');
    }

    public function blacklistChannels()
    {
        return $this->belongsToMany('App\Channel', 'blacklists', 'user_id', 'channel_id');
    }

    public function playlists()
    {
        return $this->hasMany('App\Playlist');
    }

    public function videoView()
    {
        return $this->belongsToMany('App\Video', 'video_views', 'user_id', 'video_id');
    }

    /* JWT */
    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
        ];
    }

    /**
     * Specifies the user's FCM token
     *
     * @return string
     */
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
}
