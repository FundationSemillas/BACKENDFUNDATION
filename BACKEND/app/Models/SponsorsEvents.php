<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorsEvents extends Model
{
    use HasFactory;
    protected $table = 'sponsorsEvents';
    public $timestamps = true;

    protected $fillable = [
        'description',
    ];

    public function sponsor()
    {
        return $this->belongsTo(Sponsors::class);
    }
    public function event()
    {
        return $this->belongsTo(Events::class);
    }
}
