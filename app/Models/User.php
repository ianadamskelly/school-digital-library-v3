<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function readingProgress()
    {
        return $this->hasMany(ReadingProgress::class);
    }

    public function booksCompletedThisYear()
    {
        return $this->readingProgress()
            ->where('is_completed', true)
            ->whereYear('completed_at', now()->year)
            ->count();
    }

    // Get all books the student has interacted with
    public function books()
    {
        return $this->belongsToMany(Book::class, 'reading_progress')
            ->withPivot('current_page', 'percentage', 'is_completed');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'student_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
