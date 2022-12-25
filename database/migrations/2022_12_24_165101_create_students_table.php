<?php

use App\Models\Classes;
use App\Models\Guardian;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Classes::class, 'class_id')->constrained();
            $table->enum('rstate', ['open', 'close'])->default('open');
            $table->date('admitted_at')->nullable();
            $table->string('studentid', 10)->unique('studentid');
            $table->string('firstname');
            $table->string('surname');
            $table->enum('sex',['male', 'female', 'other']);
            $table->enum('transit',['walk', 'bus']);
            $table->enum('affiliation',['staffed', 'non-staffed'])->default('non-staffed');
            $table->string('address')->nullable();
            $table->date('dateofbirth')->nullable();
            $table->tinyText('avatar')->nullable();
            $table->json('linked_files')->nullable();
            $table->foreignIdFor(Guardian::class)->nullable()->constrained();
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
        Schema::dropIfExists('students');
    }
}
