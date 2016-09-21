<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationLaravelContactModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('contacts')) {
            Schema::create('contacts', function (Blueprint $table) {
                $table->increments('id');

                $table->string('name');
                $table->string('address')->nullable();

                $table->integer('province_id')->unsigned();
                $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
                $table->integer('county_id')->unsigned();
                $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');
                $table->integer('district_id')->unsigned()->nullable();
                $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
                $table->integer('neighborhood_id')->unsigned()->nullable();
                $table->foreign('neighborhood_id')->references('id')->on('neighborhoods')->onDelete('cascade');
                $table->integer('postal_code_id')->unsigned()->nullable();
                $table->foreign('postal_code_id')->references('id')->on('postal_codes')->onDelete('cascade');

                $table->string('map_title')->nullable();
                $table->decimal('latitude', 15, 8)->nullable();
                $table->decimal('longitude', 15, 8)->nullable();
                $table->tinyInteger('zoom')->unsigned()->nullable();

                $table->boolean('is_publish')->default(0);
                $table->timestamps();

                $table->engine = 'InnoDB';
            });
        }

        if ( ! Schema::hasTable('contact_numbers')) {
            Schema::create('contact_numbers', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('contact_id')->unsigned();
                $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');

                $table->string('title');
                $table->char('number', 16); // ETC: 0(216) 333 33 33
                $table->timestamps();

                $table->engine = 'InnoDB';
            });
        }

        if ( ! Schema::hasTable('contact_emails')) {
            Schema::create('contact_emails', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('contact_id')->unsigned();
                $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');

                $table->string('title');
                $table->string('email');
                $table->timestamps();

                $table->engine = 'InnoDB';
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contact_emails');
        Schema::drop('contact_numbers');
        Schema::drop('contacts');
    }
}
