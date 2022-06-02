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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()
                ->cascadeOnUpdate();
            $table->foreignId('event_category_id')->constrained()
                ->cascadeOnUpdate();
            $table->string('title');
            $table->string('location');
            $table->date('date');
            $table->string('time');
            $table->foreignId('event_type_id')->constrained()
                ->cascadeOnUpdate();
            $table->double('price', 15, 2)->nullable();
            $table->string('description');
            $table->foreignId('status_id');
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
        Schema::dropIfExists('events');
    }
};
