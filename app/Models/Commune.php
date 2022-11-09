<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Commune extends Model
{
    use HasFactory;
    protected $table = 'communes';
    protected $fillable = ['region_id','description','status'];

    public function Region()
    {
        return $this->belongsTo(Region::class);
    }
    public function Customer()
    {
        return $this->hasMany(Customer::class);
    }
}
