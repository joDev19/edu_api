<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public function _questions(){
        return $this->hasMany(Question::class, 'epreuve_id')->get();
    }

    protected function questions(): Attribute
    {
        return new Attribute(
            get: fn () => $this->_questions(),
        );
    }
    protected function niveau(): Attribute
    {
        return new Attribute(
            get: fn () => $this->belongsTo(NiveauDeDifficulte::class, 'niveau_de_difficulte_id')->first(),
        );
    }
    protected function matiere(): Attribute
    {
        return new Attribute(
            get: fn () => $this->belongsTo(Matiere::class, 'matiere_id')->first(),
        );
    }

    protected $appends = ['questions', 'niveau', 'matiere'];

}
