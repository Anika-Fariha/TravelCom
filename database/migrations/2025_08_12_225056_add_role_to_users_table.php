<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Adding the role column
            $table->boolean('role')->default(0); // 0 for user, 1 for admin
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Dropping the role column in case of rollback
            $table->dropColumn('role');
        });
    }

};
