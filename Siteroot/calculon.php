<?php
session_name( 'calculon' );
session_start();
header( "Content-type: application/json" );
if( isset( $_POST['operator'] ) ){
  $path = dirname( __FILE__ );
  require_once( $path . "/../classes/calculator.php" );

  $myCalculon = new calculator( html_entity_decode( $_POST['operator'] ) );

exit( json_encode( array( 'success' => $myCalculon->success, 'result' => $myCalculon->result, 'message' => $myCalculon->banter(), 'memory' => $myCalculon->memory , 'debug' => $myCalculon->debug ) ) );
}
exit( json_encode( array( 'success' => false, 'result' => 'Infinity, or 42.', 'message' => "Nothing given, means nothing received!", 'memory' => $myCalculon->memory, 'debug' => $myCalculon->debug ) ) );
?>
