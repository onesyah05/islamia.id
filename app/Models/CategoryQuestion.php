<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryQuestion extends Pivot
{
    protected $table = 'category_question';
    
    protected $fillable = [
        'category_id',
        'question_id'
    ];
} 