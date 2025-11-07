<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLegacy extends Model
{
    protected $table = 'tblusers';
    protected $fillable = ['FullName','EmailId','ContactNo','Password'];
    public $timestamps = false;
}
