<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Sanctum\HasApiTokens;

class ReadingSession extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'reading_time_seconds',
        'current_page',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'reading_time_seconds' => 'integer',
        'current_page' => 'integer',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
