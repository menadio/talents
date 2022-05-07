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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('user_id');
            $table->string('facebook')->unique()->nullable()->after('postal_code');
            $table->string('instagram')->unique()->nullable()->after('facebook');
            $table->string('twitter')->unique()->nullable()->after('instagram');
            $table->string('tiktok')->unique()->nullable()->after('twitter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
            $table->dropColumn('twitter');
            $table->dropColumn('tiktok');
        });
    }
};
