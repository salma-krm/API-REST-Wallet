<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'number',
        'balance',
        'status',
    ];
    public function User(){
        return $this->hasOne(User::class);
    }
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }

}
