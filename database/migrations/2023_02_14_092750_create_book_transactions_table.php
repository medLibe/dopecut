<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name');
            $table->date('book_date');
            $table->string('phone', 50)->change()->nullable();
            $table->string('book_time', 20)->change();
            $table->foreignId('ha_id');
            $table->string('book_no');
            $table->tinyInteger('gender');
            $table->tinyInteger('book_type')->comment('1: Customer Book, 2: Admin Book');
            $table->string('cancel_reason');
            $table->timestamp('created_at')->useCurrent();
            $table->string('created_by');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('updated_by');
            $table->tinyInteger('is_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_transactions');
    }
}
