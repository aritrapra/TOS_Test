<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'title',
        'post',
        'post_by',
        'delete'
    ];

    protected $hidden = [
        'post_by'
    ];

    protected $casts = [
        'id' => 'string',
    ];
}
