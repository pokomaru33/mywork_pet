<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thedate extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function thedatetitle()
    {
        return $this->belongsToMany(Thedatetitle::class, 'thedate_thedatetitle', 'thedate_id', 'thedatetitle_id');
    }
}
