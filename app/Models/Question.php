<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'slug', 'content', 'is_answered', 'views',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function answers() { return $this->hasMany(Answer::class); }
    public function bookmarks() { return $this->hasMany(Bookmark::class); }
    public function categories() { return $this->belongsToMany(Category::class, 'category_question')->using(CategoryQuestion::class); }
} 