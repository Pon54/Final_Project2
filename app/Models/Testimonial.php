<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'tbltestimonial';
    protected $fillable = ['Testimonial','UserEmail','status'];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(\App\Models\UserLegacy::class, 'UserEmail', 'EmailId');
    }
}
