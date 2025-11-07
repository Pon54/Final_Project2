<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'tblbrands';
    protected $fillable = ['BrandName'];
    public $timestamps = false;
}
