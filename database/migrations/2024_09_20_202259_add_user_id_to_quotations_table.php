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
        Schema::table('quotations', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->after('pharmacy_user_id')->nullable(); // Adding user_id as a foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Remove foreign key
            $table->dropColumn('user_id'); // Remove user_id column
        });
    }
};
