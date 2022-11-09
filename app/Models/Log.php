<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table = 'logs';
    protected $fillable = [
        'customer_dni',        
        'email',
        'type',
        'table',
        'ip',
    ];

    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
