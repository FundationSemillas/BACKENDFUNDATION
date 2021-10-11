<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Blogs extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
    ];

    public function Event()
    {
        return $this->hasMany(Events::class);
    }
    
    function addBlogs($data)
    {
        DB::table('blogs')->insert($data);
    }
}
