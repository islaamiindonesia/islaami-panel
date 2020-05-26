<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @method static orderBy(string $string)
 * @method static max(string $string)
 * @method static firstOrCreate(array $array, array $array1)
 * @method static find(int $id)
 * @method static updateOrCreate(array $array, array $array1)
 * @method static where(string $string, $id)
 */
class Subcategory extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'number', 'category_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'category_id',
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
     * Get the category that owns the subcategory.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function scopeSearch($query, $searchQuery)
    {
        if ($searchQuery == null) return $query;
        return $query->where('name', 'LIKE', "%{$searchQuery}%");
    }
}
