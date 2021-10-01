<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThedateThedatetitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thedate_thedatetitle', function (Blueprint $table) {
            $table->primary(['thedate_id', 'thedatetitle_id']);
            $table->foreignId('thedate_id')->constrained()->onDelete('cascade');
            $table->foreignId('thedatetitle_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('thedate_thedatetitle');
    }
}
