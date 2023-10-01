<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblAdministrator', function (Blueprint $table) {
            $table->bigIncrements('fldAdministratorID');
            $table->string('fldAdministratorFirstname', 100);
            $table->string('fldAdministratorLastname', 100);
            $table->string('fldAdministratorEmail', 250);
            $table->string('fldAdministratorPassword', 250);
            $table->string('fldAdministratorMobile', 100);
            $table->string('fldAdministratorOTP', 10);
            $table->dateTime('fldAdministratorOTPExpiration');
            $table->dateTime('fldAdministratorRegistrationDate')->useCurrent();
            $table->boolean('fldAdministratorActive')->default(false);
            $table->dateTime('fldAdministratorForgotPasswordOTPExpirationDate');
            $table->string('fldAdministratorSecurity', 250);
            $table->string('fldAdministratorProfileImage', 250);
            $table->text('fldAdministratorWidget');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblAdministrator');
    }
}
