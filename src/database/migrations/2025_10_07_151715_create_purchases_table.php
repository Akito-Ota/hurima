<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')
                ->constrained()
                ->restrictOnDelete();
            $table->foreignId('item_id')
                ->constrained()
                ->unique()            
                ->restrictOnDelete();
            $table->char('shipping_postcode', 8);    
            $table->string('shipping_address', 255);     
            $table->string('shipping_building', 255)->nullable();
            $table->enum('payment_method', ['conbini', 'card']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
