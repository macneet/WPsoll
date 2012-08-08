<?php

class calculator {
  
  public $result;
  public $inputA;
  public $inputB;
  public $M = NULL;
  public $operator = false;
  public $memory;
  public $success = true;
  public $message = "Ehrr, was not quite sure what to do,.. I'm guessing the answer is approximately 12.123098835341 and a half.";
  
  public $opToFunc = array(
      '+' => 'PLUS'
      ,'PLUS' => 'PLUS'
      ,'-' => 'MINUS'
      ,'MIN' => 'MINUS'
      ,'X' => 'MULTIPLY'
      ,'MUL' => 'MULTIPLY'
      ,'/' => 'DIVIDE'
      ,'DIV' => 'DIVIDE'
      ,'M+' => 'MPLUS'
      ,'M-' => 'MMINUS'
      ,'MR' => 'MREAD'
      ,'MC' => 'MCLEAR'
      ,'CE' => 'MCLEAR'
  );

  private $responses = array(
      'zerodevision' => "My god! Are you deliberately trying to end the world?"
      ,'success' => "Well I think I got this right."
  );

  public function __construct( Silex\Application $myCalculon ){
    $Request = $myCalculon['request'];
    $this->operator = strToupper( $myCalculon->escape( $Request->get('operator') ) );
    if( $this->operator ){
      $this->inputA  = $myCalculon->escape( $Request->get('inputA') );
      $this->inputB  = $myCalculon->escape( $Request->get('inputB') );
      $this->M       = $myCalculon->escape( $Request->get('M') );
      $this->memory  = $myCalculon['session']->get('M');
      $this->result = 0;
      $func = ( ( empty( $this->M ) || $this->M === NULL )
                ? 'calculator' . $this->opToFunc[ $this->operator ]
                : $this->opToFunc[ $this->operator ] );
      $this->debug = $func;

      if( method_exists( $this, $func ) ){
        $this->banter( 'success' );
        $this-> result = $this->$func( $myCalculon );
      }
      else{
        $this->success = false;
      }
     
    }
    return array( 'success' => $this->success, 'result' => $this->result, 'message' => $this->banter(), 'memory' => $this->memory , 'debug' => $this->debug );
  }  
  
  public function banter( $response = null ){
    if( $response === null ){
      $this->message .= "<br />"
                  .  $this-> inputA . " "
                  .  $this-> operator . " "
                  .  $this-> inputB . " = "
                  .  "<strong>" . $this->result . "</strong>";
      return $this->message;
    }
    $this->message = $this->responses[ $response ];
  }
  
  
  // CALCULON
  public function calculatorPLUS(){
    return $this->inputA + $this->inputB;
  }
  
  public function calculatorMINUS(){
    return $this->inputA - $this->inputB;
  }
  
  public function calculatorMULTIPLY(){
    return $this->inputA * $this->inputB;
  }
  
  public function calculatorDIVIDE(){
    if( $this->inputB == 0 ){
      $this-> success = false;
      $this->banter( 'zerodevision' );
      return "Imposibruuuuu";
    }
    else{
      return $this->inputA / $this->inputB;
    }
  }
  
  // END CALCULON
  
  
  // MEMORY FUNCTIONS
  
  public function MCLEAR( Silex\Application $myCalculon ){
    $this->memory = 0;
    $myCalculon['session']->set('M', $this->memory );
    return $this->memory;
  }
  
  public function MRREAD(){
    return $this-> memory;
  }
  
  public function MPLUS( Silex\Application $myCalculon){
    $this->memory = $this-> memory + $this->M;
    $myCalculon['session']->set('M', $this->memory );
    return $this->memory;
  }
  
  public function MMINUS( Silex\Application $myCalculon ){
    $this->memory = $this-> memory - $this->M;
    $myCalculon['session']->set('M', $this->memory );
    return $this->memory;
  }
  
  // END MEMORY FUNCTIONS

  
}

?>
