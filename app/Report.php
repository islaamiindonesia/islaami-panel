<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static where(string $string, bool $true)
 * @method static updateOrCreate(array $array, array $array1)
 * @method static find(int $id)
 */
class Report extends Model
{
    use Notifiable;

    protected $table = "user_reports";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'description', 'image_url', 'is_solved'
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
        'is_solved' => 'boolean',
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
