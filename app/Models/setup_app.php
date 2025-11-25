<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class setup_app extends Model 
{
    use HasFactory;

    protected $table = 'setup_app';

    protected $guarded = ['id'];
}

