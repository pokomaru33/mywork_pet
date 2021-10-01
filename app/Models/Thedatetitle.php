<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thedatetitle extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function thedate(){
        return $this->belongsToMany(Thedate::class);
    }
}
