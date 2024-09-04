<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    public function consumer(){
        return $this->belongsTo(Consumer::class);
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
