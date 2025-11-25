<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class sidebar_menu extends Model 
{
    use HasFactory;

    protected $table = 'sidebar_menu';

    protected $guarded = ['id'];

    public function children()
    {
        return $this->hasMany(sidebar_menu::class, 'parent_id')->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(sidebar_menu::class, 'parent_id');
    }

}

