<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->integer('type_id');
            $table->bigInteger('organization_id');
            $table->bigInteger('created_by');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('group_users', function (Blueprint $table) {
            $table->bigInteger('group_id');
            $table->bigInteger('user_id');

            $table->index(['group_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
        Schema::dropIfExists('group_users');
    }
}
