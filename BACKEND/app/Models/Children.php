<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Children extends Model
{
    use HasFactory;
    protected $table = 'children';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'surname',
        'dateBirth',
        'age',
        'CI',
        'mothersName',
        'fathersName',
        'study',
        'houseAddress',
        'schoolName',
        'Image',
        'state',
    ];

    public function setName($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }
    public function setSurName($value)
    {
        $this->attributes['surname'] = strtoupper($value);
    }
    public function setMothersName($value)
    {
        $this->attributes['mothersName'] = strtoupper($value);
    }
    public function setFathersName($value)
    {
        $this->attributes['fathersName'] = strtoupper($value);
    }
    function addChild($data)
    {
        DB::table('children')->insert($data);
    }
}
