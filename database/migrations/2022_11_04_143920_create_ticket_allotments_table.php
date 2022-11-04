<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketAllotmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_allotments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('agent_id');
            $table->string('full_name');
            $table->unsignedBigInteger('slot_id');
            
            $table->foreign('agent_id')
            ->references('id')
            ->on('agents')
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
        Schema::dropIfExists('ticket_allotments');
    }
}
