<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @method static where(string $string, $id)
 * @method static firstOrCreate(array $array, array $array1)
 * @method static updateOrCreate(array $array, array $array1)
 */
class Label extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'number', 'subcategory_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'subcategory_id'
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
     * Get the subcategory that owns the label.
     */
    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory');
    }

    /**
     * The videos that belong to the label.
     */
    public function videos()
    {
        return $this->belongsToMany('App\Video', 'video_labels');
    }
}
