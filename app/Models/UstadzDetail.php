<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UstadzDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nama_lengkap', 'no_hp', 'alamat', 'foto', 'bio', 'keahlian', 'status',
    ];

    public function user() { return $this->belongsTo(User::class); }
} 