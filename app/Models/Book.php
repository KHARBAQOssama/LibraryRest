<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function genders()
    {
        return $this->belongsToMany(Gender::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }


    protected $fillable =[
        'title',
        'author',
        'collection',
        'isbn',
        'publication_date',
        'page_count',
        'location',
        'status_id',
        'content',
    ];
}
