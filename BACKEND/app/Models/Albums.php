<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Albums extends Model
{
    use HasFactory;
    protected $table = 'albums';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'date',
        'image'
       
    ];

    public function images()
    {
        return $this->hasMany(Images::class);
    }
    /*public function events()
    {
        return $this->belongsTo(Events::class);
    }*/

    function addAlbum($data)
    {
        DB::table('albums')->insert($data);
    }
  
}
