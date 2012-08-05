<?php

define( "SITEROOTPATH", dirname( __FILE__ ) );
define( "ROOTPATH", SITEROOTPATH . '/../' );
define( "SILEXROOTPATH", ROOTPATH . '/silex/vendor/' );
define( "TWIGROOTPATH", ROOTPATH . '/twig/lib/' );

//to show my own solution,...
if( isset( $_GET['org'] ) ){
  require( 'altindex.php' );
  exit();
}
else{
  echo "Silex and twig,...";
}

?>
