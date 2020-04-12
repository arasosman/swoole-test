<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organization_id')->index();
            $table->string('staff', 100);
            $table->string('email', 100);
            $table->string('phone', 30)->nullable();
            $table->string('gsm_phone', 30);
            $table->string('fax', 30)->nullable();
            $table->string('address', 200);
            $table->string('tax_administration', 100)->nullable();
            $table->string('tax_no', 50)->nullable();
            $table->string('logo', 250)->default('/img/org/default.png');
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
        Schema::dropIfExists('organization_profiles');
    }
}
