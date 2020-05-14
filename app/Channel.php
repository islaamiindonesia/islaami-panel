<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @method static firstOrCreate(array $array, array $array1)
 * @method static find(int $id)
 * @method static where(string $string, int $int)
 * @method static updateOrCreate(array $array, array $array1)
 */
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
}
