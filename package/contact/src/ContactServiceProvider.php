<?php

namespace Bridgemonkcorp\Contact;

class ContactServiceProvider extends \Illuminate\Support\ServiceProvider{
  public function boot(){
    $this->loadRoutesFrom(__DIR__.'/routes/web.php');
  }

  public function register()
  {

  }
}
