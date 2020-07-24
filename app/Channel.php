<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Channel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'thumbnail', 'description', 'suspended_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'suspended_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function routeNotificationForFcm()
    {
        return $this->followers()->pluck('fcm_token')->toArray();
    }

    /* RELATIONSHIP */
    public function followers()
    {
        return $this->belongsToMany('App\User', 'followers', 'channel_id', 'user_id');
    }

    public function blacklists()
    {
        return $this->belongsToMany('App\User', 'blacklists', 'channel_id', 'user_id');
    }

    public function videos()
    {
        return $this->hasMany('App\Video');
    }

    public function scopeSearch($query, $searchQuery, $filter)
    {
        if ($filter == "active") {
            $finalQuery = $query->where('suspended_at', null);
        } else {
            $finalQuery = $query->where('suspended_at', '<>', null);
        }

        if ($searchQuery == null) return $finalQuery;
        return $finalQuery->where('name', 'LIKE', "%{$searchQuery}%");
    }

    public function scopeName($query, $searchQuery)
    {
        if ($searchQuery == null) return $query;
        return $query->where('name', 'LIKE', "%{$searchQuery}%");
    }
}
