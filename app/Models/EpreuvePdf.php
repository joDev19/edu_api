<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;

class EpreuvePdf extends Model
{
    use HasFactory;
    protected $fillable = [
        'universite_id',
        'filiere_id',
        'path_enoncer',
        'path_corriger',
        'session',
        'matiere_id',
        'classe_id',
        'prix',
    ];

    public function universite(){
        return $this->belongsTo(Universite::class, 'universite_id');
    }

    public function filiere(){
        return $this->belongsTo(Filiere::class, 'filiere_id');
    }

    public function classe(){
        return $this->belongsTo(Classe::class, 'classe_id');
    }
    public function matiere(){
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }
    // add attribute is_paid: true | false
    public function isPaid(): Attribute{
        // dd(Auth::user()->paiements->contains($this));
        // dd(Auth::user()->paiements[0], $this);
        return Attribute::make(
            get: function (){
                if(Auth::user()->paiements->contains($this)) {return true;} else {return false;}
            }
        );
    }
    protected $appends = ['is_paid'];
    protected $with = ['universite', 'filiere', 'classe', 'matiere'];

}
