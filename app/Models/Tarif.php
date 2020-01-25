<?php

namespace App\Models;

use Illuminate\database\Eloquent\Model;

class Tarif extends Model
{
    // define column name
    protected $fillable = [
        'biaya', 
        'kursi'
    ];

    // Untuk melakukan update field created_at dan update_at secara otomatis
    public $timestamps = true;

    public function tarif(){

        return $this->hasMany(Booking::class,'tarif_id');

    }
}
