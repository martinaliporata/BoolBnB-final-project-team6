<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =[
        "User_id",
        "Nome",
        "Stanze",
        "Letti",
        "Bagni",
        "Metri_quadrati",
        "Prezzo",
        "Indirizzo",
        "citta",
        "Latitudine",
        "Longitudine",
        "Img",
        "Visibilità",
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function views(){
        return $this->hasMany(View::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function sponsorships(){
        return $this->belongsToMany(Sponsorship::class);
    }

    public function services(){
        return $this->belongsToMany(Service::class);
    }
}
