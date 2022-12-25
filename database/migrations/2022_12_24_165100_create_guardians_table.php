<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->enum('rstate', ['open', 'close'])->default('open');
            $table->string('title', 45);
            $table->string('firstname');
            $table->string('surname');
            $table->enum('sex',['male', 'female', 'other']);
            $table->string('phone', 14)->nullable();
            $table->string('mobile', 14)->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('occupation')->nullable();
            $table->tinyText('avatar')->nullable();
            $table->json('linked_files')->nullable();
            $table->foreignIdFor(User::class)->nullable()->constrained();
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
        Schema::dropIfExists('guardians');
    }
}
