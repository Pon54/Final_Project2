<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLegacy extends Model
{
    protected $table = 'tblusers';
    protected $fillable = ['FullName','EmailId','ContactNo','Password'];
    public $timestamps = false;

    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class, 'userEmail', 'EmailId');
    }

    public function testimonials()
    {
        return $this->hasMany(\App\Models\Testimonial::class, 'UserEmail', 'EmailId');
    }
}
