<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'tblpages';
    protected $fillable = ['PageName','type','detail'];
    public $timestamps = false;
}
