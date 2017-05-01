<?php
use Illuminate\Database\Migrations\Migration;

class RemoveOrphanClients extends Migration
{

  /**
   * Removes documents from the client collection that have
   * an lrs_id that does not exist in the lrs collection.
   *
   * @return void
   */
  public function up()
  {
    $dbName = config('database.connections.mongodb.database');
    $dbManager = new \MongoDB\Driver\Manager();
    $clients = DB::collection('client');
    $lrss = DB::collection('lrs');
    
    $clientCursor = $clients->where([], ['lrs_id' => true])->find();
    
    foreach ($clientCursor as $client) {
      $count = $lrss->count(['_id' => $client['lrs_id']]);
      if ($count == 0) {
        $clients->remove(['_id' => $client['_id']]);
      }
    }
  }

  public function down()
  {
    //
  }
}
