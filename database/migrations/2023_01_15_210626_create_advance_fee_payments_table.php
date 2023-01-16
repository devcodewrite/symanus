<?php

use App\Models\Attendance;
use App\Models\Bill;
use App\Models\FeeType;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceFeePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_fee_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class)->constrained();
            $table->decimal('amount');
            $table->date('paid_for_date');
            $table->foreignIdFor(Attendance::class)->nullable();
            $table->foreignIdFor(FeeType::class)->constrained();
            $table->string('paid_by')->nullable();
            $table->foreignIdFor(User::class)->constrained();
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
        Schema::dropIfExists('advance_fee_payments');
    }
}
