<?php

define( "SITEROOTPATH", dirname( __FILE__ ) );
define( "ROOTPATH", SITEROOTPATH . '/../../' );
define( "SILEXROOTPATH", ROOTPATH . 'silex/vendor/' );
define( "TWIGTEMPLATESPATH", ROOTPATH . 'templates/' );

function printr( $what, $text = 'Output', $halt = false){
  echo"<pre>" . $text . " " . print_r( $what, 1 ) . "</pre>";
  if( $halt ){
    exit;
  }
}

require_once SILEXROOTPATH.'autoload.php';
$app = new Silex\Application();
$app['debug'] = ( getenv('APP_DEV_STATUS') === 'development' );
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => TWIGTEMPLATESPATH,
));

$app['calculator'] = function () {
    return new Service();
};

$app->get('/calculon/', function () use ($app) {
    return $app['twig']->render('calculon.twig' );
});

$app->run();

?>
