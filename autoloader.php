<?php

Class AutoLoader
{
  public function __construct() {
    spl_autoload_register( array( $this, 'loader' ) );
  }

  private function loader( $className ) {
    include $className . '.php';
  }
}

?>