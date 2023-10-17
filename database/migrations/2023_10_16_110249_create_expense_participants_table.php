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
        Schema::create('expense_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id'); // Foreign key to the expenses table
            $table->unsignedBigInteger('user_id'); // Foreign key to the users table
            $table->enum('split_method', ['equal', 'percentage', 'by_amount'])->default('equal');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('expense_id')->references('id')->on('expenses_detail')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_participants');
    }
};
