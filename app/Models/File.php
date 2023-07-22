<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    const disk = 'app';
    const CREATER_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'url',
        'user_id',
    ];
}
