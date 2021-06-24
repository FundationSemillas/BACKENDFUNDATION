<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    
    protected $table = 'events';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'place',
        'date',
        'hour',
        'delay',
    ];
    
    public function blog()
    {
        return $this->belongsTo(Blogs::class);
    }
    public function sponsorEvent()
    {
        return $this->hasMany(SponsorEvents::class);
    }
    public function volunteerEvent()
    {
        return $this->hasMany(SponsorEvents::class);
    }
   /* public function albums()
    {
        return $this->hasMany(Albums::class);
    }*/
}
