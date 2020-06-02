<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'video_id', 'url', 'thumbnail', 'description',
        'published_at', 'is_published', 'is_published_now', 'is_upload_shown',
        'channel_id', 'category_id', 'subcategory_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'channel_id', 'category_id', 'subcategory_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime:Y-m-d H:i',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_published' => 'boolean',
        'is_published_now' => 'boolean',
        'is_upload_shown' => 'boolean',
    ];

    /* RELATIONSHIP */
    public function users()
    {
        return $this->belongsToMany('App\User', 'later_video', 'video_id', 'user_id');
    }

    public function playlist()
    {
        return $this->belongsToMany('App\Playlist', 'playlist_video', 'video_id', 'playlist_id');
    }

    /**
     * Get the channel that owns the video.
     */
    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }

    /**
     * Get the category that owns the video.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Get the subcategory that owns the video.
     */
    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory');
    }

    /**
     * The labels that belongs to video.
     */
    public function labels()
    {
        return $this->belongsToMany('App\Label', 'video_labels', 'video_id', 'label_id')
            ->select(array('label_id as id', 'name'));
    }

    /**
     * The views that belongs to video.
     */
    public function views()
    {
        return $this->belongsToMany('App\User', 'video_views', 'video_id', 'user_id');
    }

    public function scopeSearch($query, $searchQuery, $filter)
    {
        $isPublished = $filter == "true";
        if ($searchQuery == null) return $query->where('is_published', $isPublished);
        return $query
            ->where('title', 'LIKE', "%{$searchQuery}%")
            ->where('is_published', $isPublished);
    }

    public function scopeSearchTitle($query, $searchQuery)
    {
        return $query->where('title', 'LIKE', "%{$searchQuery}%");
    }
}
