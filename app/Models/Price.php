<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $fillable = ['price', 'products_id', 'name'];

    public function product() {
       return $this->hasOne('App\Model\Products');
    }
}
