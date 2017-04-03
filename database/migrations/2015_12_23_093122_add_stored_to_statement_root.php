<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStoredToStatementRoot extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		set_time_limit(0);

		$db = \DB::getMongoDB();
    $statementsCollection = new MongoDB\Collection($db, 'statements');
    
    $statementsCollection->createIndex(['stored' => 1], ['background'=>1, 'socketTimeoutMS'=>-1]);
    $statementsCollection->createIndex(['stored' => -1], ['background'=>1, 'socketTimeoutMS'=>-1]);
    $statementsCollection->createIndex(['lrs_id' => 1, 'stored' => 1], ['background'=>1, 'socketTimeoutMS'=>-1]);
    $statementsCollection->createIndex(['lrs_id' => 1, 'stored' => -1], ['background'=>1, 'socketTimeoutMS'=>-1]);

    $statementsCursor = $statementsCollection->find();

    $remaining = $statementsCursor->count();
    print($remaining . ' statements total' . PHP_EOL);

    $maxBatchSize = 10000;

    while($statementsCursor->hasNext()) {
	    $batch = new \App\MongoUpdateBatch($statementsCollection);
	    $batchSize = 0;

	    while($batchSize < $maxBatchSize && $statementsCursor->hasNext()) {
	    	$batchSize++;
	    	$statement = $statementsCursor->next();
	    	$statementStored = new Carbon\Carbon($statement['statement']['stored']);

	    	$query = [
				  'q' => ['_id' => $statement['_id']],
				  'u' => ['$set' => ["stored" => new \MongoDB\BSON\UTCDateTime($statementStored->timestamp, $statementStored->micro)]],
				  'multi' => false,
				  'upsert' => false,
				];

	    	if(isset($statement['refs'])) {
	    		foreach ($statement['refs'] as $key => $refStatement) {
	    			if(isset($refStatement['timestamp']) && !$refStatement['timestamp'] instanceof\MongoDB\BSON\UTCDateTime) {
              $timestamp = new Carbon\Carbon($refStatement['timestamp']);
              $query['u']['$set']['refs.'.$key.'.timestamp'] = new \MongoDB\BSON\UTCDateTime($timestamp->timestamp, $timestamp->micro);
            } 
	    			if(isset($refStatement['stored']) && !$refStatement['stored'] instanceof\MongoDB\BSON\UTCDateTime) {
              $stored = new Carbon\Carbon($refStatement['stored']);
              $query['u']['$set']['refs.'.$key.'.stored'] = new \MongoDB\BSON\UTCDateTime($stored->timestamp, $stored->micro);
            }
	    		}
	    	}

				$batch->add((object) $query);
	    }
	    $batch->execute();
	    $remaining -= $batchSize;

	    print($remaining . ' remaining' . PHP_EOL);
    }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$db = \DB::getMongoDB();
    $statementsCollection = new MongoDB\Collection($db, 'statements');
    
    $statementsCollection->deleteIndex('stored');
    $statementsCollection->deleteIndex(['lrs_id' => 1, 'stored' => -1]);

    $statementsCollection->update([], ['$unset' => ["stored" => ""]], ['multiple' => true]);

    $statementsCursor = $statementsCollection->find();
    $remaining = $statementsCursor->count();
    print($remaining . ' statements total' . PHP_EOL);

    $maxBatchSize = 10000;

    while($statementsCursor->hasNext()) {
	    $batch = new \App\MongoUpdateBatch($statementsCollection);
	    $batchSize = 0;
	    $shouldExecute = false;

	    while($batchSize < $maxBatchSize && $statementsCursor->hasNext()) {
	    	$batchSize++;
	    	$statement = $statementsCursor->next();

	    	if(isset($statement['refs'])) {
		    	$query = [
					  'q' => ['_id' => $statement['_id']],
					  'u' => ['$set' => []],
					  'multi' => false,
					  'upsert' => false,
					];
	    		foreach ($statement['refs'] as $key => $refStatement) {
            if(isset($refStatement['timestamp']) && $refStatement['timestamp'] instanceof \MongoDB\BSON\UTCDateTime ) {
              $query['u']['$set']['refs.'.$key.'.timestamp'] = date('Y-m-d\TH:i:s.uP', $refStatement['timestamp']->sec);
            }
            if(isset($refStatement['stored']) && $refStatement['stored'] instanceof \MongoDB\BSON\UTCDateTime ) {
              $query['u']['$set']['refs.'.$key.'.stored'] = date('Y-m-d\TH:i:s.uP', $refStatement['stored']->sec);
            }
	    		}
          
          if(!empty($query['u']['$set'])) {
						$batch->add((object) $query);
						$shouldExecute = true;
					}
	    	}
	    }

	    if($shouldExecute) $batch->execute();
	    $remaining -= $batchSize;

	    print($remaining . ' remaining' . PHP_EOL);
    }
	}

}
