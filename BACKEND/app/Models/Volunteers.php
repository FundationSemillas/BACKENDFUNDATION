<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteers extends Model
{
    use HasFactory;
     protected $fillable = [
         'name',
         'surname',
         'CI',
        'description',
        'address',
        'availability',
        'telefonNumber',
        'image',
        'state',
    ];

    public function volunteersEvents()
    {
        return $this->hasMany(VolunteersEvents::class);
    }
}
