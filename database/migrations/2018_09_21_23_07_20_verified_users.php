<?php

use Modulus\Hibernate\Capsule;
use Illuminate\Database\Schema\Blueprint;

class VerifiedUsers
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Capsule::schema()->create('verified_users', function ($table) {
      $table->increments("id");
      $table->string("email")->index();
      $table->string("token");
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
    Capsule::schema()->dropIfExists('verified_users');
  }
}
