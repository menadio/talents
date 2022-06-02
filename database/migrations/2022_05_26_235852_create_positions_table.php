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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()
                ->cascadeOnUpdate();
            $table->string('title');
            $table->foreignId('category_id')->constrained()
                ->cascadeOnUpdate();
            $table->double('salary', 8, 2);
            $table->foreignId('employment_type_id')->constrained()
                ->cascadeOnUpdate();
            $table->string('location');
            $table->string('description');
            $table->boolean('open')->default(true);
            $table->foreignId('status_id')->constrained('statuses')
                ->cascadeOnUpdate();
            $table->foreignId('approved_by')->nullable()
                ->constrained('users');
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
        Schema::dropIfExists('positions');
    }
};
