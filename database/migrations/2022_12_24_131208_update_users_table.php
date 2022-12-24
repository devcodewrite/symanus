<?php

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
            $table->string('phone', 14)->nullable()->unique('phone');
            $table->tinyText('avatar')->nullable();
            $table->foreignIdFor(UserRole::class)->constrained();
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
            $table->string('email')->nullable(false)->change();
            $table->dropConstrainedForeignId('user_role_id');
            $table->dropSoftDeletes();
        });
        Schema::dropColumns('users', ['username','firstname', 'surname', 'phone', 'avatar']);
    }
}
