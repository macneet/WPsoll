<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of calculator
 *
 * @author Rene Lensink<rene@nocommerce.nl>
 */
class calculator {
  
  public $result;
  public $inputA;
  public $inputB;
  public $memory;
  public $success = true;
  public $message = "Ehrr, was not quite sure what to do,.. I'm guessing the answer is approximately 12.123098835341 and a half.";
  
  public $opToFunc = array(
      '+' => 'PLUS'
      ,'-' => 'MINUS'
      ,'X' => 'MULTIPLY'
      ,'/' => 'DIVIDE'
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

  public function __construct( $operator ){
    
    $this-> inputA  = isset( $_POST['inputA'] )?(FLOAT)$_POST['inputA']['value']:null;
    $this-> inputB  = isset( $_POST['inputB'] )?(FLOAT)$_POST['inputB']['value']:null;
    $this-> M       = isset( $_POST['M'] )?(FLOAT)$_POST['M']:null;
    $this-> memory  = isset( $_SESSION['M'] )?$_SESSION['M']:0;
    $this-> operator = $operator;
    $this->result = 0;
    $func = ( isset( $_POST['M'] )?$this->opToFunc[ strToupper( $operator ) ] :'calculator' . $this->opToFunc[ strToupper( $operator ) ] );
    $this->debug = $func;
    
    if( method_exists( $this, $func ) ){
      $this->banter( 'success' );
      $this-> result = $this->$func();
    }
    else{
      $this->success = false;
    }

    return $this;
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
  
  public function MCLEAR(){
    $this->memory = 0;
    $_SESSION['M'] = $this->memory;
    return $this->memory;
  }
  
  public function MRREAD(){
    return $this-> memory;
  }
  
  public function MPLUS(){
    $this->memory = $this-> memory + $this->M;
    $_SESSION['M'] = $this->memory;
    return $this->memory;
  }
  
  public function MMINUS(){
    $this->memory = $this-> memory - $this->M;
    $_SESSION['M'] = $this->memory;
    return $this->memory;
  }
  
  // END MEMORY FUNCTIONS

  
}

?>
