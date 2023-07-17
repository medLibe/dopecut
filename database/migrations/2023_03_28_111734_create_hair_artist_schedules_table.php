<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHairArtistSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hair_artist_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_transaction_id');
            $table->foreignId('ha_id');
            $table->string('schedule_time', 20)->change()->nullable();
            $table->date('schedule_date')->nullable();
            $table->tinyInteger('schedule_type');
            $table->text('description');
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
        Schema::dropIfExists('hair_artist_schedules');
    }
}
