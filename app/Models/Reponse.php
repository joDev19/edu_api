<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;
    protected $fillable = [
        'intitule',
        'juste',
        'question_id',
    ];
    protected $casts = [
        'juste' => 'boolean',
    ];
}
