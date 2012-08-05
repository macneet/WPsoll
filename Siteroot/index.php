<?php

define( "SITEROOTPATH", dirname( __FILE__ ) );
define( "ROOTPATH", SITEROOTPATH . '/../' );
define( "SILEXROOTPATH", ROOTPATH . '/silex/vendor/' );
define( "TWIGROOTPATH", ROOTPATH . '/twig/lib/' );

function printr( $what, $text = 'Output', $halt = false){
  echo"<pre>" . $text . " " . print_r( $what, 1 ) . "</pre>";
  if( $halt ){
    exit;
  }
}

//to show my own solution,...
if( isset( $_GET['org'] ) ){
  require( 'altindex.php' );
  exit();
}
else{
  require_once SILEXROOTPATH.'autoload.php';

  $app = new Silex\Application();

  $app->get('/hello/{name}', function ($name) use ($app) {
    printr( $name );
      return 'Hello '.$app->escape($name);
  });

  $app->run();
  
}

?>
