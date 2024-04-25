<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'intitule',
        'type',
        'epreuve_id',
    ];
    public function reponses(){
        return $this->hasMany(Reponse::class, 'question_id')->get();
    }
}
