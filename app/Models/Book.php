<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Book extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'google_books_id',
        'title',
        'author',
        'total_pages',
        'publication_year',
        'category',
        'cover_image',
        'description',
    ];

    protected $casts = [
        'total_pages' => 'integer',
        'publication_year' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function readingSessions()
    {
        return $this->hasMany(ReadingSession::class);
    }
}
