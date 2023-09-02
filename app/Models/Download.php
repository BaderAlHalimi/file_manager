<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;
    protected $fillable = ['file_id', 'ip','city'];
    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
