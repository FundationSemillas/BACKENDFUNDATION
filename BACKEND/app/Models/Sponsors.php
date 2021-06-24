<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Sponsors extends Model
{
    use HasFactory;
    protected $table = 'sponsors';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public function sponsorsEvent()
    {
        return $this->hasMany(SponsorsEvents::class);
    }

    function addSponsor($data)
    {
        DB::table('sponsors')->insert($data);
    }
  
}
