<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();            
            $table->unsignedBigInteger('user_id');            
            $table->unsignedBigInteger('slot_id');
            $table->date('date');
            $table->string('time_slot');
            $table->string('room_name');
            $table->tinyInteger('capacity');
            $table->decimal('fee', 6, 2);  
            $table->string('email_address'); 
            $table->string('reference_number'); 

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('slot_id')
            ->references('id')
            ->on('slots')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_sales');
    }
}
