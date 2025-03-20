<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beds', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->unsignedBigInteger('room_id'); // Foreign key to rooms
            $table->string('bed_number')->unique();
            $table->enum('status', ['Available', 'Occupied'])->default('Available');
            $table->timestamps(); // Created_at, Updated_at
            $table->softDeletes(); // Soft Deletes column

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beds');
    }
}
