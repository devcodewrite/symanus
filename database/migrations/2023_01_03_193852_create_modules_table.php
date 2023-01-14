<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name',45);
            $table->string('group_label',60)->index('group_label');
            $table->enum('status', ['enabled', 'disabled']);
            $table->enum('default_status',['enabled', 'disabled'])->nullable();
            $table->boolean('locked')->default(0);
            $table->tinyText('description')->nullable();
            $table->tinyText('icon')->nullable();
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
        Schema::dropIfExists('modules');
    }
}
