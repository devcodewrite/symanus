<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->set('settings', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('permissions', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('modules', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('user_roles', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('users', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('students', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('guardians', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('classes', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('attendances', ['view','create','update', 'delete', 'force-delete','report','approve-attendance'])->nullable();
            $table->set('fee_types', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('fees', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('expense_types', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('expenses', ['view','create','update', 'delete', 'force-delete','report', 'approve-expense'])->nullable();
            $table->set('bills', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('semesters', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('staffs', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->set('sms', ['view','create','update', 'delete', 'force-delete','report'])->nullable();
            $table->boolean('locked')->default(0);
            $table->boolean('is_admin')->default(0);
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
        Schema::dropIfExists('permissions');
    }
}
