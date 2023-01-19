<?php

use App\Models\ExpenseReport;
use App\Models\ExpenseType;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('edate');
            $table->string('description');
            $table->foreignIdFor(ExpenseType::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(ExpenseReport::class);
            $table->decimal('amount',8,2,true);
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
        Schema::dropIfExists('expenses');
    }
}
