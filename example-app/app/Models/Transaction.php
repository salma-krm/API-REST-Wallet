<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable=[
        'description',
        'amount',
        'date',
        'status',
        'sender_id',
        'receiver_id',
    ];
    public function wallet(){
        return $this->belongsTo(Wallet::class);
    }
}
