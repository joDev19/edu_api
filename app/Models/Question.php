<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'intitule',
        'type',
        'epreuve_id',
    ];
    public function _reponses(){
        return $this->hasMany(Reponse::class, 'question_id')->get();
    }
    protected function reponses(): Attribute
    {
        return new Attribute(
            get: fn () => $this->_reponses(),
        );
    }
    protected $appends = ['reponses'];
}
