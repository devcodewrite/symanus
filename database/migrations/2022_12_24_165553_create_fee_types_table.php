<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('status', ['open', 'close'])->default('open');
            $table->enum('bill_ex_st_affiliation',['staffed', 'non-staffed'])->nullable();
            $table->enum('bill_ex_st_transit',['walk', 'bus'])->nullable();
            $table->enum('bill_ex_st_attendance',['present', 'absent'])->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('fee_types');
    }
}
