<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @method static find(int $id)
 */
class Insight extends Model
{
    use Notifiable;

    protected $table = "user_insights";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'detail'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
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

    /**
     * Get the user that owns the recommendation.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeSearch($query, $filter)
    {
        if ($filter == "solved") {
            return $query->where('is_solved', true);
        } else {
            return $query->where('is_solved', false);
        }
    }
}
