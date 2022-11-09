<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $table = 'regions';
    protected $fillable = ['description','status'];

    public function Commune()
    {
        return $this->hasMany(Commune::class);
    }
    public function Customer()
    {
        return $this->hasMany(Customer::class);
    }
}
