<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('EmployeeID');
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('gender')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('national_id')->nullable();
            $table->string('passport_id')->nullable();
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('martial_status')->nullable();
            $table->string('military_status')->nullable();
            $table->string('neighbourhood')->nullable();
            $table->string('city')->nullable();
            $table->string('governorate')->nullable();
            $table->text('address')->nullable();
            $table->string('landline1')->nullable();
            $table->string('landline2')->nullable();
            $table->string('mobile1')->nullable();
            $table->string('mobile2')->nullable();
            $table->string('email')->nullable();
            $table->text('qualifications')->nullable();
            $table->text('experience')->nullable();
            $table->text('chronic_internal_diseases')->nullable();
            $table->text('pandemic_viruses')->nullable();
            $table->text('medicine')->nullable();
            $table->text('hypersensitivity')->nullable();
            $table->text('disability')->nullable();
            $table->string('smoker')->nullable()->default('0');
            $table->string('medical_glasses')->nullable()->default('0');
            $table->string('medical_ear_headphones')->nullable()->default('0');
            $table->string('severe_injuries')->nullable()->default('0');
            $table->string('surgery')->nullable()->default('0');
            $table->text('medical_issues')->nullable();
            $table->string('judged')->nullable()->default('0');
            $table->string('wanted_for_cases')->nullable()->default('0');
            $table->string('lecturer_against_you')->nullable()->default('0');
            $table->string('judicial_Disputes')->nullable()->default('0');
            $table->string('debts_or_mortgages')->nullable()->default('0');
            $table->string('job_id')->nullable();
            $table->string('management_id')->nullable();
            $table->string('emplpoyment_date')->nullable();
            $table->text('salary_type')->nullable();
            $table->text('salary_request_type')->nullable();
            $table->string('salary')->nullable();
            $table->text('attachments')->nullable();
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
        Schema::dropIfExists('employment_profiles');
    }
}
