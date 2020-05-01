<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppPolicy extends Model
{
    public $incrementing = false;
    protected $table = 'app_policies';
    protected $primaryKey = 'name';
    protected $fillable = ['name', 'content'];
}
