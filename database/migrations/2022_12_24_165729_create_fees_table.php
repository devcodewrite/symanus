<?php

use App\Models\Classes;
use App\Models\FeeType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->foreignIdFor(Classes::class, 'class_id')->nullable()->constrained();
            $table->foreignIdFor(FeeType::class)->constrained();
            $table->decimal('amount',8,2,true);
            $table->enum('rstatus', ['open', 'close'])->default('open');
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
        Schema::dropIfExists('fees');
    }
}
