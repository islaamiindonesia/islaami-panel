<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Playlist extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /* RELATIONSHIPS */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function videos()
    {
        return $this->belongsToMany('App\Video', 'playlist_video', 'playlist_id', 'video_id');
    }

    public function scopeSearchVideo($searchQuery)
    {
        return $this->videos()->where('title', 'LIKE', "%{$searchQuery}%");
    }
}
