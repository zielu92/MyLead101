<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'sku', 'user_id'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function price() {
        return $this->hasMany('App\Models\Price');
    }
}
