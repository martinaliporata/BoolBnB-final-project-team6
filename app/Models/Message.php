<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = ['apartment_id', 'Mail', 'Testo'];

    public function apartment(){
        return $this->belongsTo(Apartment::class);
    }
}
