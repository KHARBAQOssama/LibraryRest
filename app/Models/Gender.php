<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    protected $fillable = [
        'name'
    ];
}
