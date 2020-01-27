<?php

namespace App\Models;

use Illuminate\database\Eloquent\Model;

class Pembayaran extends Model
{
    // define column name
    protected $fillable = [
        'total', 
        'booking_id'
    ];

    // Untuk melakukan update field created_at dan update_at secara otomatis
    public $timestamps = true;

    public function booking(){

        return $this->belongsTo(Booking::class,'booking_id');

    }
}
