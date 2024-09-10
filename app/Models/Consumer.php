<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cognome', 'data_di_nascita', 'email', 'password'];

    // Nascondi il campo password quando restituisci i dati dell'utente
    protected $hidden = ['password', 'remember_token'];


}
