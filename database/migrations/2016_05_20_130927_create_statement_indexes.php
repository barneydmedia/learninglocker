<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatementIndexes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
    $db = \DB::getMongoDB();

    $indexOptions = ['background'=>1, 'socketTimeoutMS'=>-1];

    Schema::table('statements', function (Blueprint $table) use ($indexOptions) {
      $table->index(['statement.id' => 1, 'lrs_id' => 1], $indexOptions);
      $table->index(['statement.actor.mbox' => 1], $indexOptions);
      $table->index(['stored' =>  1], $indexOptions);
      $table->index(['timestamp' =>  1], $indexOptions);
      $table->index(['active' =>  1], $indexOptions);
      $table->index(['voided' => 1], $indexOptions);
      $table->index(['lrs_id' => 1], $indexOptions);
      $table->index(['lrs_id' => 1, 'active' => -1, 'voided' => 1], $indexOptions);
      $table->index(['lrs_id' => 1, 'statement.actor.account.name' => 1, 'statement.actor.account.homePage' => 1], $indexOptions);
      $table->index(['lrs_id' => 1, 'statement.actor.mbox' => 1], $indexOptions);
      $table->index(['lrs_id' => 1, 'statement.verb.id' => 1], $indexOptions);
      $table->index(['lrs_id' => 1, 'statement.object.id' => 1], $indexOptions);
      $table->index(['lrs_id' => 1, 'stored' => -1], $indexOptions);
      $table->index(['lrs_id' => 1, 'timestamp' => -1], $indexOptions);
    });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
    // we really don't want to remove this indexes
	}

}
