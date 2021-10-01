<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getAvatarAttribute($value) {
        if (strpos($value, 'https://') !== FALSE || strpos($value, 'http://') !== FALSE) {
            return $value;
        }
        if($value === null){
            return "";
        }
        return asset('storage/' . $value);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function weight(){
        return $this->hasMany(Weight::class);
    }
    public function note(){
        return $this->hasMany(Note::class);
    }
    public function date(){
        return $this->hasMany(Date::class);
    }
}
