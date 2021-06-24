<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteersEvents extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
    ];

    public function volunteer()
    {
        return $this->belongsTo(Volunteers::class);
    }
    public function event()
    {
        return $this->belongsTo(Events::class);
    }
}
