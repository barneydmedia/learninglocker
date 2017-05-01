<?php
use Illuminate\Database\Migrations\Migration;

class SiteSuperUserId extends Migration
{

  /**
   * Converts site.super[{user}] value from string to MongoId.
   *
   * @return void
   */
  public function up()
  {
    // @TODO


    // $db = \DB::getMongoDB();
    // $sites = new DB::collection('site');
    // $sitesCursor = $sites->where([], ['super' => true])->find();
    
    // foreach ($sitesCursor as $site) {
    //   foreach ($site['super'] as $key => $supers) {
    //     $sites->update(
    //       ['_id' => $site['_id']],
    //       ['$set' => ["super.$key.user" => new MongoId($supers['user'])]],
    //       ['multiple' => true]
    //     ); 
    //   }
    // }
  }

  /**
   * Converts site.super[{user}] value from MongoId to string.
   *
   * @return void
   */
  public function down()
  {
    // $db = \DB::getMongoDB();
    //   $sites = new DB::collection('site');
    // $sitesCursor = $sites->where([], ['super' => true])->find();
    
    // foreach ($sitesCursor as $site) {
    //   foreach ($site['super'] as $key => $supers) {
    //     $sites->update(
    //       ['_id' => $site['_id']],
    //       ['$set' => ["super.$key.user" => (string)$supers['user']]],
    //       ['multiple' => true]
    //     ); 
    //   }
    // }
  }
}
