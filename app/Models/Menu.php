<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'gh_menus';
    protected $fillable = [
        'nm_menu',
        'nm_link',
        'sg_icon',
        'ic_ativo',
        'ic_raiz',
        'ic_parent'
    ];

    protected $casts = [
        'ic_ativo' => 'boolean',
        'ic_raiz' => 'boolean'
    ];
    public $timestamps = true;
}