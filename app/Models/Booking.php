<?php

namespace App\Models;

use Illuminate\database\Eloquent\Model;

class Booking extends Model
{
    // define column name
    protected $fillable = [
        'meja_id', 
        'tarif_id',
        'user_id',
        'tanggal_booking',
        'status'
    ];

    // Untuk melakukan update field created_at dan update_at secara otomatis
    public $timestamps = true;

    public function mejao(){
        return $this->belongsTo(Meja::class,'meja_id');
    }
    public function tarifo(){
        return $this->belongsTo(Tarif::class,'tarif_id');
    }
    


}
