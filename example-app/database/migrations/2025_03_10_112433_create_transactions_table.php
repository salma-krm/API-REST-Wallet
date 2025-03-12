<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('description');    
            $table->float('amount');
            $table->date('date');
            $table->enum('status',['annuler','terminer'])->default('terminer');
            $table->foreignId('sender_id')->constrained('wallets')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('wallets')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
