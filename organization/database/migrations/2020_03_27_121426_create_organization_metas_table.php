<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_metas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organization_id')->index();
            $table->string('key', 50);
            $table->text('value');
            $table->timestamps();

            $table->index(['organization_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_metas');
    }
}
