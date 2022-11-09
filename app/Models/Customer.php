<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends  Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    
    protected $table = 'customers';
    protected $primaryKey = 'dni';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'region_id',
        'commune_id',
        'dni',
        'email',
        'name',
        'last_name',
        'address',
        'status'
    ];

    public function Region()
    {
        return $this->belongsTo(Region::class);
    }
    public function Commune()
    {
        return $this->belongsTo(Commune::class);
    }
    public function Log()
    {
        return $this->hasMany(Log::class,'customer_dni');
    }
}
