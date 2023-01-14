<?php

use App\Models\Permission;
use App\Models\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add changes
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('name');
            $table->string('email')->nullable()->change();
            $table->string('username')->unique('username');
            $table->string('firstname');
            $table->string('surname');
            $table->enum('sex', ['male', 'female', 'other'])->default('male');
            $table->string('phone', 14)->nullable()->unique('phone');
            $table->tinyText('avatar')->nullable();
            $table->foreignIdFor(UserRole::class)->constrained();
            $table->foreignIdFor(Permission::class)->nullable()->constrained();
            $table->enum('rstate', ['open', 'close'])->default('open');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // remove changes
        Schema::table('users', function(Blueprint $table){
            $table->string('name');
            $table->dropConstrainedForeignId('user_role_id');
            $table->dropConstrainedForeignId('permission_id');
            $table->dropSoftDeletes();
        });
        Schema::dropColumns('users', ['username','firstname', 'surname', 'phone', 'avatar', 'sex']);
    }
}
