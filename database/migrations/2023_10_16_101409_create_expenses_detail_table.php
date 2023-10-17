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
        Schema::create('expenses_detail', function (Blueprint $table) {
            $table->id();
            $table->string('expense_title');
            $table->decimal('amount', 10, 2); // Use decimal for accurate money values
            $table->date('date');
            $table->tinyInteger('split_method')->nullable()->comment('1 = Equal, 2 =  Percentage, 3 = Amount');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->text('description')->nullable();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
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
        Schema::dropIfExists('expenses_detail');
    }
};
