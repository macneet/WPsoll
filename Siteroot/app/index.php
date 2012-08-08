<?php

define( "SITEROOTPATH", dirname( __FILE__ ) . '/' );
define( "ROOTPATH", SITEROOTPATH . '../../' );
define( "SILEXROOTPATH", ROOTPATH . 'silex/vendor/' );
define( "TWIGTEMPLATESPATH", ROOTPATH . 'templates/' );

require_once SILEXROOTPATH.'autoload.php';

$myCalculon = new Silex\Application();
$myCalculon['debug'] = ( getenv('APP_DEV_STATUS') === 'development' );
$myCalculon->register( new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => TWIGTEMPLATESPATH,
));


$myCalculon->match( 'calculon/result' , function () use ( $myCalculon ) {
    require_once( SITEROOTPATH . "calculator.php" );
  
    $myCalculon->register( new Silex\Provider\SessionServiceProvider( array( 'name' => 'calculon' ) ) );

    $myCalculon['data'] = $myCalculon->before(function ( Request $request ) {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
        }
    });
    
    
    $myCalculon['calculator_service'] = function( $myCalculon ){
      return new calculator( $myCalculon );
    };

    return $myCalculon->json( $myCalculon['calculator_service'] );
});


$myCalculon->get('/', function () use ($myCalculon) {
    return $myCalculon['twig']->render('calculon.twig' );
});

$myCalculon->run();
?>
