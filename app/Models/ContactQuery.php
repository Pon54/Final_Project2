<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactQuery extends Model
{
    protected $table = 'tblcontactusquery';
    protected $fillable = ['name','EmailId','ContactNumber','Message'];
    
    protected $casts = [
        'created_at' => 'datetime',
    ];
}
