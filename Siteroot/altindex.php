<?php
session_name( 'calculon' );
session_start();
if( isset( $_POST['operator'] ) ){
  header( "Content-type: application/json" );
  $path = dirname( __FILE__ );
  require_once( $path . "/../classes/calculator.php" );

  $myCalculon = new calculator( html_entity_decode( $_POST['operator'] ) );

  exit( json_encode( array( 'success' => $myCalculon->success, 'result' => $myCalculon->result, 'message' => $myCalculon->banter(), 'memory' => $myCalculon->memory , 'debug' => $myCalculon->debug ) ) );
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head lang="en" xml:lang="en">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Calculon</title>
  <link href="/style/calculon.css" title="calculon" type="text/css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script src="/calculon.js"></script>
</head>

<body>
  <div id="vertcenter">
    <div id="calculon">
      <div id="fondMems">
      </div>
      <div id="resultdisplay" class="orangeOnBlack">
        <div id="results">0</div>
        <div id="resultdisplayGlass">
        </div>
      </div>  
      <ul id="keypad">
        <li>C</li><li>CE</li><li>MC</li><li>+/-</li>
        <li>MR</li>
        <ul id="memorybench">
          <li>M+</li><li>M-</li>
        </ul>
        <li class="operator">+</li>
        <li>7</li><li>8</li><li>9</li><li class="operator">-</li>
        <li>4</li><li>5</li><li>6</li><li class="operator">x</li>
        <li>1</li><li>2</li><li>3</li><li class="operator">/</li>
        <li>0</li><li>.</li><li class="doublew"> = </li>
      </ul>
      <div id="banter"></div>
      <ul id="display" title="Click to choose the display colorcombo">
        <li class="">&bull;</li>
          <li class="orangeOnBlack">&bull;</li>
          <li class="BlackOnOrange">&bull;</li>
      </ul>
    </div>
  </div>
  
  
</body>
</html>