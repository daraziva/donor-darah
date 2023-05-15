<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;
    protected $table = 'donor';
    protected $fillable = [
        'name',
        'age',
        'weight',
        'email',
        'phoneNumber',
        'bloodType',
        'file'
    ];
    //hasOne : one to one
    //table yg  berperan sebagai pk
    //nama fungsi == nama model fk 
    
    public function response()
    {
        return $this->hasOne(Response::class);
    }

}

