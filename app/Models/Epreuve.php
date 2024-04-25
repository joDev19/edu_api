<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epreuve extends Model
{
    use HasFactory;
    protected $fillable = [
        "intitule",
        "share",
        "matiere_id",
        "niveau_de_difficulte_id",
        "duree",
    ];

    public function questions(){
        return $this->hasMany(Question::class, 'epreuve_id')->get();
    }
}
