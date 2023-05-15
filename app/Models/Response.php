<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Donor;

class Response extends Model
{
    use HasFactory;
    protected $fillable=[
        'donor_id',
        'status',
        'jadwal',
    ];

    //hasOne : one to one
    //table yg berperan sebagai pk
    //nama fungsi disamakan dengana nama model 
    public function donor()
    {
        return $this->belongsTo
        (Donor::class);
    }
}
