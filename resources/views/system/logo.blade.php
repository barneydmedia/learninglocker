<a class="navbar-brand" href="/">
  <?php
    $site = \App\Site::first();
    if( isset($site->name) ){
      $site = $site->name;
    }else{
      $site = 'Learning Locker';
    }
  ?>
  {{ isset($title) ? $title : $site }}
</a>